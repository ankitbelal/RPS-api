<?php

namespace App\Http\Controllers\programs;
use App\Http\Requests\ProgramRequest;
use App\Models\programs\Program;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Exports\ProgramSampleExport;
use App\Http\Requests\ProgramBulkImportRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    protected $apiResponse;
    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // default 10
        $page = $request->input('page', 1); // default page 1

        $programs = Program::orderBy('id', 'asc')->paginate($perPage, ['*'], 'page', $page);
        if($programs){
            $paginatedData=$this->apiResponse->paginatedData($programs);
            return $this->apiResponse->successResponse("Programs fetched successfully", $paginatedData);
        }
        else{
            return $this->apiResponse->failedResponse("No programs found", null, 404);
        }
    }

    public function show($id)
    {
        $program = Program::find($id);
        if ($program) {
            return response()->json($program);
        } else {
            return response()->json(['message' => 'Program not found'], 404);
        }
    }

    public function store(ProgramRequest $request)
    {
     
        $data = $request->validated();
        $program = Program::create($data);
        if ($program) {
            return $this->apiResponse->successResponse("Program created successfully", $program, 201);
        } else {
            return $this->apiResponse->failedResponse("Failed to create program", null, 400);
        }
    }

    public function update(ProgramRequest $request, $id)
    {
        $program = Program::find($id);
        if ($program) {
            $data = $request->validated();
            $program->update($data);
            return response()->json($program);
        } else {
            return response()->json(['message' => 'Program not found'], 404);
        }
    }
    public function destroy($id)
    {
        $program = Program::find($id);
        if ($program) {
            $program->delete();
            return response()->json(['message' => 'Program deleted successfully']);
        } else {
            return response()->json(['message' => 'Program not found'], 404);
        }
    }

    // should import the package for excel data map and download sample data
    public function bulkRegisterProgram(Request $request)
    {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $headerRowIndex = 7; // row 8 in Excel
        $codesInFile = [];
        $errors = [];
        $dataToInsert = [];

        // Expected header in B:G
        $expectedHeader = ['code', 'name', 'duration_years', 'total_semesters', 'total_subjects', 'description'];

        // Map header from B:G
        $header = [
            strtolower(trim($rows[$headerRowIndex][1] ?? '')),
            strtolower(trim($rows[$headerRowIndex][2] ?? '')),
            strtolower(trim($rows[$headerRowIndex][3] ?? '')),
            strtolower(trim($rows[$headerRowIndex][4] ?? '')),
            strtolower(trim($rows[$headerRowIndex][5] ?? '')),
            strtolower(trim($rows[$headerRowIndex][6] ?? '')),
        ];

        if ($header !== $expectedHeader) {
            return $this->apiResponse->failedResponse(
                'Header row does not match expected format: ' . implode(', ', $expectedHeader),
                422
            );
        }

        $dataStartRowIndex = $headerRowIndex + 1; // row 9 in Excel = line 1

        // Validate all rows first
        for ($i = $dataStartRowIndex; $i < count($rows); $i++) {
            $row = $rows[$i];

            $data = [
                'code' => trim($row[1] ?? null),
                'name' => trim($row[2] ?? null),
                'duration_years' => $row[3] ?? null,
                'total_semesters' => $row[4] ?? null,
                'total_subjects' => $row[5] ?? null,
                'description' => trim($row[6] ?? ''),
            ];

            // Skip completely empty or template rows
            if (empty($data['code']) && empty($data['name'])) {
                continue;
            }

            $lineNumber = $i - $dataStartRowIndex + 1;

            // Row-level validation
            $rowValidator = Validator::make($data, [
                'code' => 'required|string|max:10|alpha_num',
                'name' => 'required|string|max:255',
                'duration_years' => 'required|integer|min:1',
                'total_semesters' => 'required|integer|min:1',
                'total_subjects' => 'required|integer|min:1',
                'description' => 'nullable|string|max:500',
            ]);

            if ($rowValidator->fails()) {
                foreach ($rowValidator->errors()->all() as $message) {
                    $errors[] = "Line {$lineNumber}: {$message}";
                }
                continue;
            }

            // Check duplicates in uploaded file
            if (in_array($data['code'], $codesInFile)) {
                $errors[] = "Line {$lineNumber}: code '{$data['code']}' is duplicated in uploaded file";
                continue;
            }

            // Check duplicates in database
            if (Program::where('code', $data['code'])->exists()) {
                $errors[] = "Line {$lineNumber}: code '{$data['code']}' already exists";
                continue;
            }

            $codesInFile[] = $data['code'];
            $dataToInsert[] = $data;
        }

        // If any errors exist, block all insertion
        if (count($errors) > 0) {
            return $this->apiResponse->failedResponse(
                "failed to register programs",
                ['errors' => $errors],
                422
            );
        }

        // All rows are valid, insert in transaction
        DB::transaction(function () use ($dataToInsert) {
            foreach ($dataToInsert as $data) {
                Program::create($data);
            }
        });

        return $this->apiResponse->successResponse(
            count($dataToInsert) . " programs registered successfully",
            null,
            201
        );
    }



    public function downloadSampleProgram(){
        try {
            $export = new ProgramSampleExport();
            return $export->download('program_sample.xlsx');
        } catch (Exception $e) {
            return $this->apiResponse->failedResponse("Error generating sample file: " . $e->getMessage(), null, 500);
        }
    }

}