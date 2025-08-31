<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Processing System - NAST</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        header {
            background: linear-gradient(to right, #1a2a6c, #2a4b8c);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }
        
        .logo {
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 2.5rem;
            color: #ffcc00;
        }
        
        h1 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .main-content {
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        @media (max-width: 900px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card h2 {
            color: #1a2a6c;
            border-bottom: 2px solid #ffcc00;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .system-info {
            grid-column: 1 / -1;
            text-align: center;
            background: linear-gradient(to right, #f5f7fa, #c3cfe2);
            padding: 2rem;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .feature i {
            color: #1a2a6c;
            font-size: 1.2rem;
        }
        
        .dev-team {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        @media (max-width: 600px) {
            .dev-team {
                grid-template-columns: 1fr;
            }
        }
        
        .developer {
            padding: 1.2rem;
            background: #f8f9fa;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .developer:hover {
            background: #e9ecef;
            transform: scale(1.02);
        }
        
        .developer-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1a2a6c;
            margin-bottom: 1rem;
        }
        
        .developer-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1a2a6c;
            margin-bottom: 0.3rem;
        }
        
        .developer-role {
            color: #6c757d;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .developer-links {
            display: flex;
            gap: 0.8rem;
        }
        
        .developer-links a {
            color: #1a2a6c;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .developer-links a:hover {
            color: #fdbb2d;
            transform: scale(1.2);
        }
        
        .actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn {
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: #1a2a6c;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2a4b8c;
            transform: scale(1.05);
        }
        
        footer {
            background: #1a2a6c;
            color: white;
            padding: 1.5rem;
            text-align: center;
            margin-top: 2rem;
            border-radius: 0 0 15px 15px;
        }
        
        .nast-link {
            color: #ffcc00;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .nast-link:hover {
            text-decoration: underline;
        }
        
        .status {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #4caf50;
            color: white;
            border-radius: 30px;
            font-size: 0.9rem;
            margin-left: 1rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        .upload-btn {
            margin-top: 0.5rem;
            padding: 0.4rem 0.8rem;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .upload-btn:hover {
            background: #5a6268;
        }
        
        .file-input {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1>Result Processing System</h1>
            <p class="subtitle">Efficient, Accurate, and Reliable Result Management</p>
            <span class="status">LIVE</span>
        </header>
        
        <div class="main-content">
            <div class="system-info">
                <h2>Welcome to the Result Processing System</h2>
                <p>This system provides a comprehensive solution for managing and processing academic results with advanced analytics and reporting capabilities.</p>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-info-circle"></i> About the System</h2>
                <p>The Result Processing System is designed to streamline the entire result management process, from data entry to publication.</p>
                
                <div class="features">
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Secure Data Management</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Real-time Processing</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Advanced Analytics</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Automated Reports</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Bulk Registration</span>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-users"></i> Development Team</h2>
                <p>This system was developed by a dedicated team of professionals:</p>
                
                <div class="dev-team">
                    <div class="developer">
                        <img src={{ asset('devs/ankit.jpg') }} alt="Ankit Belal" class="developer-img">
                        <div class="developer-name">Ankit Belal</div>
                        <div class="developer-role">Full Stack Developer</div>
                        <div class="developer-links">
                            <a href="https://github.com/ankitbelal" title="GitHub"><i class="fab fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/ankit-belal-398968183/" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                       
                    </div>
                    
                    <div class="developer">
                        <img src={{ asset('devs/yubraj.jpg') }} alt="Yubraj Dhungana" class="developer-img">
                        <div class="developer-name">Yubraj Dhungana</div>
                        <div class="developer-role">Full Stack Developer</div>
                        <div class="developer-links">
                            <a href="https://github.com/yubiStona" title="GitHub"><i class="fab fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/yubraj-dhungana-2b63982a4/" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                        
                    </div>
                    
                    <div class="developer">
                        <img src="{{ asset('devs/milan.jpg') }}" alt="Milan Belal" class="developer-img">
                        <div class="developer-name">Milan Belal</div>
                        <div class="developer-role">Full Stack Developer</div>
                        <div class="developer-links">
                            <a href="https://github.com/Belal172" title="GitHub"><i class="fab fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/milan-belal-8a522b352/" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                       
                    </div>
                    
                    <div class="developer">
                       <img src="{{ asset('devs/aarya.JPG') }}" alt="Aarya Singh" class="developer-img">
                        <div class="developer-name">Aarya Singh</div>
                        <div class="developer-role">Frontend Developer</div>
                        <div class="developer-links">
                            <a href="https://github.com/aaryasingh12" title="GitHub"><i class="fab fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/aarya-singh-03b367379/" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                       
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-chart-line"></i> System Statistics</h2>
                <p>Current system usage and performance metrics:</p>
                <p style="margin-top: 1rem; font-style: italic; color: #666;">
                    Statistics will be displayed here once available.
                </p>
            </div>
            
            <div class="card actions">
                <h2><i class="fas fa-cogs"></i> Quick Actions</h2>
                <button class="btn btn-primary">
                    <a style="color: #fff;" href="https://ui-rps.vercel.app/"><i class="fas fa-sign-in-alt"></i> Login to System</a>
                </button>
            </div>
        </div>
        
        <footer>
            <p>Powered by</p>
            <h3>National Academy of Science and Technology (NAST)</h3>
            <a href="https://nast.edu.np/" target="_blank" class="nast-link">
                <i class="fas fa-external-link-alt"></i> Visit NAST Website
            </a>
            <div id="datetime" style="margin-top: 1rem; color: #fff;"></div>
        </footer>
    </div>

    <script>
        // Simple animation for buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mouseover', () => {
                button.style.transform = 'scale(1.05)';
            });
            
            button.addEventListener('mouseout', () => {
                button.style.transform = 'scale(1)';
            });
        });
        
        // Display current date and time
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const dateTimeStr = now.toLocaleDateString('en-US', options);
            document.getElementById('datetime').textContent = dateTimeStr;
        }
        
        setInterval(updateDateTime, 1000);
        updateDateTime();
        
        // Upload photo functionality
        document.querySelectorAll('.upload-btn').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const fileInput = document.querySelectorAll('.file-input')[index];
                fileInput.click();
            });
        });
        
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    const imgElement = this.parentElement.querySelector('.developer-img');
                    
                    reader.onload = function(e) {
                        imgElement.src = e.target.result;
                    };
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
</body>
</html>