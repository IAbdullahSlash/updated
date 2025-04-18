    
    
    <?php 
    session_start();
    
    ?>
    
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/page1.css?v=<?php echo time()?>">
        <title>SafeBrowse</title>
    </head>

    <body>
        <header>
            <nav class="navbar">
            <div class="menu-icon" id="hamburger-icon" onclick="showSidebar()">
                &#9776;
            </div>
            <span><a href="index.php" class="SB">SafeBrowse</a></span>
                <!-- <ul class="navham">
                    <li onclick="hideSidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 96 960 960" width="26" ><path d="m249 849-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/></svg></a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#footer">Contacts</a></li>
                </ul> -->
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#footer">Contacts</a></li>
                
                <?php if(isset($_SESSION["logged_in"]) && $_SESSION['logged_in']): ?>
                    <a class="nav-links" href="logout.php">Logout</a>
                    
                    <?php else: ?>
                <button class="get-started-btn" onclick="redirectToLogin()">Register now!</button>
                <?php endif; ?>
            </nav>
        </header>

        <main>
            <section id="hero" class="hero">

                <div class="hero-content">
                    <h1>SafeBrowse - An Analyzer</h1>
                </div>

                <div class="hero-content2">
                    <p><strong>SAFEBROWSE- BEFORE YOU BELIEVE</strong></p>
                    <p>chatbot to detect and identify harmful content.</p>
                </div>
                <?php if(isset($_SESSION["logged_in"])&& $_SESSION["logged_in"]): ?>
                    <a href="home_page.php"><button  class="get-started-btn">Back to chatbot</button></a>

                    <?php else: ?>
                <button id="getStartedBtn" class="get-started-btn">Get Started</button>
                <?php endif; ?>
            </section>
            <section>
                <div class="what-we-do reveal">
                    <div class="what-we-do-vdo"> 
                        <video  type="video/mp4" autoplay loop muted src="media/newww.mp4"></video>
                    </div>
                    <div class="what-we-do-p">
                    <p>SafeBrowse is an Artificial Intelligence integrated platform which provides real time chatbox interface. SafeBrowse provides you with a tool that generate text from a prompt that a user provides. It can process and extracts information from documents of various formats and user provided links and also from the uploaded pdfs and images </p>
                    </div>
                </div>
            </section>
        
            

            <section class="revolution reveal">
                <div class="wrapper">
                    <div class="itemLeft item1">SafeBrowse is an AI-powered platform designed to detect and identify harmful content across text, images, and files. </div>
                    <div class="itemLeft item2">Using cutting-edge machine learning algorithms, it analyzes content for hate speech, misinformation, cyberbullying, and explicit material.</div>
                    <div class="itemLeft item3">SafeBrowse provides real-time corrections, content moderation suggestions, and actionable insights to ensure a safer digital environment.</div>
                    <div class="itemLeft item4">SafeBrowse is an AI-powered platform designed to detect and identify harmful content across text, images, and files. </div>
                    <div class="itemLeft item5">Using cutting-edge machine learning algorithms, it analyzes content for hate speech, misinformation, cyberbullying, and explicit material.</div>
                    <div class="itemLeft item6">SafeBrowse provides real-time corrections, content moderation suggestions, and actionable insights to ensure a safer digital environment.</div>
                    <div class="itemLeft item7">SafeBrowse is an AI-powered platform designed to detect and identify harmful content across text, images, and files. </div>
                    <div class="itemLeft item8">Using cutting-edge machine learning algorithms, it analyzes content for hate speech, misinformation, cyberbullying, and explicit material.</div>
                </div>
                <div class="wrapper">
                    <div class="itemRight item1">Using cutting-edge machine learning algorithms, it analyzes content for hate speech, misinformation, cyberbullying, and explicit material.</div>
                    <div class="itemRight item2">SafeBrowse provides real-time corrections, content moderation suggestions, and actionable insights to ensure a safer digital environment.</div>
                    <div class="itemRight item3">SafeBrowse is an AI-powered platform designed to detect and identify harmful content across text, images, and files. </div>
                    <div class="itemRight item4">Using cutting-edge machine learning algorithms, it analyzes content for hate speech, misinformation, cyberbullying, and explicit material.</div>
                    <div class="itemRight item5">SafeBrowse provides real-time corrections, content moderation suggestions, and actionable insights to ensure a safer digital environment.</div>
                    <div class="itemRight item6">SafeBrowse is an AI-powered platform designed to detect and identify harmful content across text, images, and files. </div>
                    <div class="itemRight item7">Using cutting-edge machine learning algorithms, it analyzes content for hate speech, misinformation, cyberbullying, and explicit material.</div>
                    <div class="itemRight item8">SafeBrowse provides real-time corrections, content moderation suggestions, and actionable insights to ensure a safer digital environment.</div>
                </div>
            </section>
        
            <div class="media reveal">

                <div class="media-h1">
                <h1>Features You Get! </h1>
                </div>
                <div class="boxes">
                    <!-- First box -->
                    <div class="box1">
                        <i class="fa-solid fa-paperclip fa-2x"></i>

                        <p align="center">Providing you with an attachment option to support various formats of contents such as documents(.docs), PDFs(.pdf), spreadsheets(.txt), templates (PPT), images and other file formats.
                            Note: maximum file size should be 7 MB.
                    </p>
                        </div>
                    
                    <!-- Second box -->
                    <div class="box2">
                        <i class="fa-solid fa-language fa-2x"></i>                    
                        <p align="center">SafeBrowse offers extensive multilingual capabilities, empowering users to seamlessly navigate, comprehend, and engage with the platform in the language they feel most comfortable with.</p>
                        </div>

                    <!-- Third box -->
                    <div class="box3">
                        <i class="fa-solid fa-microphone fa-2x"></i>
                        <p align="center">Our new audio recording feature allows you to bypass text and speak directly to the prompt field. Click the record button and let your voice be heard!</p>
                </div>
                </div>
            </div>

            <section class="username">
                <div class="U1 reveal">
                    <div class="image">
                    <img src="media/output.svg">
                    </div>
                    <div class="user">
                        <p>SafeBrowse's structured risk analysis and correction feature ensures a proactive approach to online safety by systematically analyzing content and guiding users toward secure interactions. It functions in three essential steps: first, it identifies and highlights potentially harmful or risky content, alerting users to threats such as misinformation, inappropriate material, or malicious elements. Next, it provides corrective suggestions, offering revised, safer versions of flagged content to maintain integrity and security. Finally, it recommends appropriate actions to mitigate risks, helping users navigate online spaces responsibly. This structured approach makes SafeBrowse a reliable tool for individuals, businesses, and organizations committed to a safer digital experience.
                        </p>
                    </div>
                </div>
            </section>
            
            <section id="about" class="about">
                <div class="about-content reveal">
                        
                        
                        <div class="about-title">
                            <div class="words">
                                <h2 class="word-1">About </h2>
                                
                                <h2 class="word-2">Us</h2>
                            </div>
                            <div class="container">
                                
                                <div class="about-p">
                                    <p>We are a team of tech enthusiasts with passion in solving real life problems through technology. We are a committed group of students who wants to make the internet browsing safe. Our mission is to create surfing on internet a safe experience for its users. We help you in doing so by providing you with a platform made exclusively for your safety.</p>
                                </div>
                                
                            </div>
                        </div>
                        
                    

                </div>
            </section>
        
            <!-- FAQ Section -->
            <section class="faq-section">
                <div class="faq-container">
                    <div class="faq-header">
                        <h2>FAQs</h2>
                        <h1>Frequently Asked Questions</h1>
                    </div>

                    <div class="faq-items">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>what do you mean by harmful content?</h3>
                                <button class="faq-toggle">
                                    <span class="minus">-</span>
                                    <span class="plus">+</span>
                                </button>
                            </div>
                            <div class="faq-answer">
                                <p>Harmful content refers to any material—whether text, images, videos, or audio—that can cause physical, emotional, psychological, or societal harm to individuals or communities. This includes content that promotes violence, abuse, hate speech, discrimination, or harassment, as well as misinformation that misleads people on critical issues such as health, politics, or safety.  </p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What service does SafeBrowse provide?</h3>
                                <button class="faq-toggle">
                                    <span class="minus">-</span>
                                    <span class="plus">+</span>
                                </button>
                            </div>
                            <div class="faq-answer">
                                <p>SafeBrowse provides AI-powered content analysis for text, images, and files to detect and identify any type of harmful content. Our platform offers real-time scanning and detailed reports to help users make informed decisions about online content.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Is there any cost associated in using the platform?</h3>
                                <button class="faq-toggle">
                                    <span class="minus">-</span>
                                    <span class="plus">+</span>
                                </button>
                            </div>
                            <div class="faq-answer">
                                <p>No, Safebrowse is a completely free platfrom which is build for the benefit of public and a fact checker tool against the malicious content online. </p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>What file types does SafeBrowse support?</h3>
                                <button class="faq-toggle">
                                    <span class="minus">−</span>
                                    <span class="plus">+</span>
                                </button>
                            </div>
                            <div class="faq-answer">
                                <p>SafeBrowse supports a wide range of file types including images (JPG, PNG, GIF), documents (PDF, DOCX, PPT, TXT), spreadsheets (XLSX, CSV), and other common file formats. Maximum file size is 7MB per file</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Is my data secure with SafeBrowse?</h3>
                                <button class="faq-toggle">
                                    <span class="minus">-</span>
                                    <span class="plus">+</span>
                                </button>
                            </div>
                            <div class="faq-answer">
                                <p>Yes, we take data security very seriously. All uploaded content is encrypted during transmission and storage. We do not store your content longer than necessary for analysis, and we never share your data with third parties without your explicit consent.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- <footer>
            <div id="footer" class="footer-content">
                <div class="footer-section2">
                    <h3>Support</h3>
                    <p>FAQs</p>
                </div>
                <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: support@safebrowse.com</a></p>
                </div>
                <div class="git">
                    <i class="fa-brands fa-github"></i><br><br><br>
                    <hr>
                    <div class="git_a">
                    <p><a href="https://github.com/Darakhshan-dev">Darakhshan</a></p>
                    <p><a href="https://github.com/IAbdullahSlash"> Abdullah</a></p>
                    <p><a href="https://github.com/katyayaniRK"> katyayani </a></p>
                    <p><a href="https://github.com/StriverFaizan"> Faizan </a></p>
                    <p>#Team 404Fixers</p>
                    </div>
                </div>
            </div>
        </footer> -->

        <footer>
        <div id="footer" class="footer-content">
            <div class="footer-section2">
                <h3>Support</h3>
                <p>FAQs</p>
            </div>
            <div class="footer-section">
              <h3>Contact Us</h3>
              <p>Email: support@safebrowse.com</a></p>
            </div>
            <div class="LinkedIn">
                <i class="fa-brands fa-linkedin-in"></i><br><br>    
                
                <div class="LinkedIn_a">
                <p><a href="https://www.linkedin.com/in/darakhshan-ifraque-6287a1320?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app">Darakhshan</a></p>
                <p><a href="https://www.linkedin.com/in/abdullah-azmi-492120359?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"> Abdullah</a></p>
                <p><a href="https://www.linkedin.com/in/katyayani-r-75129423b?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"> katyayani </a></p>
                <p><a href="https://linkedin.com/comm/mynetwork/discovery-see-all?usecase=PEOPLE_FOLLOWS&followMember=faizan-raza-a1265526a"> Faizan </a></p>
                <p>#Team 404Fixers</p>
                </div>
            </div>
        </div>
    </footer>
    
        <!-- Fixed Popup Modal -->
        <div id="popupModal" class="popup-modal">
            <div class="popup-content">
                <span class="close-modal">&times;</span>
                <h2>Choose Your Experience</h2>
                <div class="modal-options">
                    <div class="option-card without-login">
                        <div class="option-header">
                            <h3>Basic Access</h3>
                        </div>
                        <div class="option-features">
                            <div class="feature">
                                <i class="fa-solid fa-xmark"></i>
                                <span>Structured output</span>
                            </div>
                            <div class="feature">
                                <i class="fa-solid fa-xmark"></i>
                                <span>Attach files</span>
                            </div>
                            <div class="feature">
                                <i class="fa-solid fa-check"></i>
                                <span>Limited interaction</span>
                            </div>
                            <div class="feature">
                                <i class="fa-solid fa-check"></i>
                                <span>Text-analysis only</span>
                            </div>
                        </div>
                        <button id="continueWithoutLoginBtn" class="modal-btn secondary-btn" onclick="continueWithoutLogin()">
                            Continue without Login
                        </button>
                    </div>
                    
                    <div class="option-card with-login">
                        <div class="option-header">
                            <h3>Full Access</h3>
                        </div>
                        <div class="option-features">
                            <div class="feature">
                                <i class="fa-solid fa-check"></i>
                                <span>Structured output</span>
                            </div>
                            <div class="feature">
                                <i class="fa-solid fa-check"></i>
                                <span>Attach files</span>
                            </div>
                            <div class="feature">
                                <i class="fa-solid fa-check"></i>
                                <span>Attach images</span>
                            </div>
                            <div class="feature">
                                <i class="fa-solid fa-check"></i>
                                <span>Audio support</span>
                            </div>
                        </div>
                        <button id="continueWithLoginBtn" class="modal-btn primary-btn" onclick="continueWithLogin()">
                            Continue with Login
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <!-- Scripts -->
        <script src="scripts/page1.js?v=<?php echo time()?>"></script>
    </body>

    </html>