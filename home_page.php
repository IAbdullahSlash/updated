
    <?php
      session_start();  
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>SafeBrowse</title>
        <link rel="stylesheet" href="styles/Style.css?v=<?php echo time(); ?>">
        <style>
            /* Additional styles for loading animation and stop button */
            .loading-dots {
                display: inline-block;
            }
            
            .loading-dots::after {
                content: '';
                animation: dots 1.5s infinite;
            }
            
            @keyframes dots {
                0% { content: ''; }
                25% { content: '.'; }
                50% { content: '..'; }
                75% { content: '...'; }
                100% { content: ''; }
            }
            
            .stop-btn svg {
                width: 20px;
                height: 20px;
            }
            
            .stop-btn {
                background-color: #d32f2f !important;
            }
            
            .stop-btn:hover {
                background-color: #b71c1c !important;
            }

            .nav-links li{
                list-style: none;
            }
        </style>
    </head>
    <body>
        <div class="overlay"></div>
        <div class="sidebar">
            <button class="new-chat">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                New chat
            </button>
            <div class="recent-label">Recent</div>
            <ul class="chat-list">
                <li><a href="#" class="chat-item">What is harmful content?</a></li>
                <li><a href="#" class="chat-item">Classify harmful content</a></li>
                <li><a href="#" class="chat-item">How does AI detect and recognize such content?</a></li>
            </ul>
                <div class="extra-menu hidden">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php#about">About Us</a></li>
                        <!-- <li><a href="services.php">Services</a></li> -->
                        <li><a href="index.php#footer">Contact</a></li>
                        <!-- <li><a href="profile.php">Profile</a></li> -->
                        <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true): ?>
                          <li><a href="logout.php">Logout</a></li>

                        <?php endif; ?>

                    </ul>
                </div>
            <div class="show-more">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
                Show more
            </div>
        </div>

        <header class="header">
            <nav class="nav">
                <div class="nav-left">
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <span class="title">SafeBrowse</span>
                </div>

                <ul class="nav-links">
                <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true): ?>
                    <li><a href="index.php"><img width="20px" src="media/home-button-svgrepo-com.svg"> </a></li>
                <?php else: ?>
            
                    <li><a href="login.php" class="btn-register">Register now</a></li>
                <?php endif; ?>
                </ul>
            </nav>
            </header>


        <section class="main">
            <div class="main-title">
                <h1>
                    <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true):?>
                    <span class="typing-text">Hello, <?php echo htmlspecialchars($_SESSION["username"])."👋"  ; ?></span>
                    <?php else: ?>
                        <span class="typing-text">Hello there! Welcome 👋 </span> 
                        <?php endif; ?>
                </h1>
            </div>
            <p class="subtitle">How may I help you?</p>
            <div class="chat-background" style="display: none;">
                <div class="chat-messages">
                    <div class="message-wrapper">
                        <!-- Your chat content will go here -->
                    </div>
                </div>
                
            </div>
        </section>

        <div class="chat-box fade-in">
            <form class="form" id="chatForm">                           
                <div class="search">
                <input 
                    type="text" 
                    class="chat-input" 
                    id="chatInput"
                    placeholder="Type your message..."
                    required
                >
                </div>
                <div class="button-group">
                    <button type="button" class="attach-btn" aria-label="Attach file">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                        </svg>
                    </button>
                    <button type="submit" class="submit-btn" id="submitBtn" aria-label="Send">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </form>
            <div class="attachment-options">
                <button type="button" class="attachment-option" data-type="file">File</button>
                <button type="button" class="attachment-option" data-type="image">Image</button>
                <button type="button" class="attachment-option" data-type="audio">Audio</button>
            </div>
        </div>
        
        <div class="disclaimer">
            AI responses may not be 100% accurate. Please verify important information from trusted sources.
        </div>
        
        <input type="file" id="fileInput" style="display: none;" accept=".txt,.pdf,.doc,.docx, .pptx">
        <input type="file" id="imageInput" style="display: none;" accept="image/*">
        <input type="file" id="audioInput" style="display: none;" accept="audio/*">

        <script>
            // Sidebar toggle functionality
            const sidebarIcon = document.querySelector('.sidebar-icon');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');

            function toggleSidebar() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            }

            sidebarIcon.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

        document.addEventListener("DOMContentLoaded", function() {
            const showMoreDiv = document.querySelector(".show-more"); // Target div instead of button
            const extraMenu = document.querySelector(".extra-menu");

            if (showMoreDiv && extraMenu) { 
                showMoreDiv.addEventListener("click", function() {
                    extraMenu.classList.toggle("hidden"); // Toggle menu visibility

                    // Change arrow icon based on visibility
                    if (!extraMenu.classList.contains("hidden")) {
                        showMoreDiv.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="18 15 12 9 6 15"></polyline>
                        </svg> Show less`;
                    } else {
                        showMoreDiv.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg> Show more`;
                    }
                });
            } else {
                console.error("Show More div or Extra Menu not found!");
            }
        });

            // Replace the Google AI initialization code with this:
            const API_KEY = "AIzaSyCqc3zIUa59r7UvNbn7gy6rhRXbsZ6NcxE";
            
            // Variable to store the current fetch controller for aborting requests
            let currentController = null;

            async function initializeChat() {
                const history = [];
                const systemInstruction = "Your name is SafeBrowse. You are an AI agent responsible for detecting and recognizing harmful content, including misinformation, hate speech, and cyberbullying, from given data. You should highlight such content, provide corrections, and suggest appropriate actions accordingly. You were made by the team 404 fixers. If data has been given with the intention not related to your main mission, you should just explain why it's not from your expertise. Also, tell about yourself only when asked.";

                // Add system instruction to history
                history.push({ role: 'system', content: systemInstruction });

                return { history };
            }

            let chatState;
            let isGenerating = false;

            // Initialize chat when the page loads
            window.addEventListener('load', async () => {
                chatState = await initializeChat();
            });

            // Function to simulate typing effect
            function typeMessage(element, text, speed = 30) {
                let i = 0;
                element.innerHTML = 'SB:<br>'; // Start with just the prefix
                
                function type() {
                    if (i < text.length && isGenerating) {
                        if (text.charAt(i) === '\n') {
                            element.innerHTML += '<br>';
                        } else {
                            element.innerHTML += text.charAt(i);
                        }
                        i++;
                        scrollToBottom();
                        setTimeout(type, speed);
                    } else if (i >= text.length) {
                        // Typing is complete, reset the button
                        resetSendButton();
                    }
                }
                
                type();
            }
            
            // Function to convert send button to stop button
            function convertToStopButton() {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.classList.add('stop-btn');
                submitBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="6" y="6" width="12" height="12" />
                    </svg>
                `;
                submitBtn.setAttribute('aria-label', 'Stop');
                
                // Change the button's event listener
                submitBtn.removeEventListener('click', handleSubmit);
                submitBtn.addEventListener('click', stopGeneration);
                
                isGenerating = true;
            }
            
            // Function to reset send button
            function resetSendButton() {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.classList.remove('stop-btn');
                submitBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                `;
                submitBtn.setAttribute('aria-label', 'Send');
                
                // Reset the button's event listener
                submitBtn.removeEventListener('click', stopGeneration);
                submitBtn.addEventListener('click', handleSubmit);
                
                isGenerating = false;
            }
            
            // Function to stop generation
            function stopGeneration(e) {
                e.preventDefault();
                if (currentController) {
                    currentController.abort();
                    currentController = null;
                }
                isGenerating = false;
                resetSendButton();
                
                // Update the loading message to indicate it was stopped
                const loadingElement = document.querySelector('.loading-message');
                if (loadingElement) {
                    loadingElement.innerHTML = `
                        <div class="message-content">
                            <img src="media/logo.jpg" alt="SafeBrowse" class="bot-avatar">
                            <div class="message-text">
                                SB:<br>Response generation stopped.
                            </div>
                        </div>
                    `;
                }
            }
            
            // Function to handle form submission
            async function handleSubmit(e) {
                if (e) e.preventDefault();
                if (isGenerating) return; // Prevent multiple submissions
                
                const message = document.getElementById('chatInput').value;
                if (!message.trim()) return; // Don't submit empty messages
                
                document.querySelector('.main-title').style.display = 'none';
                document.querySelector('.subtitle').style.display = 'none';
                
                document.querySelector('.chat-background').style.display = 'block';

                // Create a new message element
                const messageElement = document.createElement('div');
                messageElement.classList.add('message', 'sender-message');
                messageElement.innerHTML = `
                    <div class="message-content">
                        <i class="fa-solid fa-circle-user fa-2x"></i>                      
                        <div class="message-text">
                            YOU:<br>${message}
                        </div>
                    </div>
                `;

                // Add the message element to the chat messages container
                const messageWrapper = document.querySelector('.message-wrapper');
                messageWrapper.appendChild(messageElement);
                
                // Scroll to bottom after adding user message
                scrollToBottom();

                // Clear input after sending
                document.getElementById('chatInput').value = ''; 
                
                // Create loading message with typing effect
                const loadingElement = document.createElement('div');
                loadingElement.classList.add('message', 'receiver-message', 'loading-message');
                loadingElement.innerHTML = `
                    <div class="message-content">
                        <img src="media/logo.jpg" alt="SafeBrowse" class="bot-avatar">
                        <div class="message-text">
                            SB:<br>Thinking<span class="loading-dots"></span>
                        </div>
                    </div>
                `;
                
                // Add the loading message to the chat
                messageWrapper.appendChild(loadingElement);
                scrollToBottom();
                
                // Convert send button to stop button
                convertToStopButton();

                try {
                    // Add user message to history
                    chatState.history.push({ role: 'user', content: message });

                    // Prepare the request body
                    const requestBody = {
                        contents: [
                            {
                                parts: [
                                    { text: chatState.history.map(msg => `${msg.role}: ${msg.content}`).join('\n') }
                                ]
                            }
                        ]
                    };

                    console.log('Request body:', JSON.stringify(requestBody, null, 2));
                    
                    // Create an AbortController to be able to cancel the fetch
                    currentController = new AbortController();
                    const signal = currentController.signal;

                    // Generate response
                    const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${API_KEY}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(requestBody),
                        signal: signal
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                    }

                    const result = await response.json();
                    console.log('API response:', JSON.stringify(result, null, 2));

                    if (!result.candidates || result.candidates.length === 0) {
                        throw new Error('No response generated from the AI.');
                    }

                    const botResponse = result.candidates[0].content.parts[0].text;

                    // Add bot response to history
                    chatState.history.push({ role: 'assistant', content: botResponse });

                    // Remove the loading message
                    messageWrapper.removeChild(loadingElement);
                    
                    // Create and add bot response element
                    const responseElement = document.createElement('div');
                    responseElement.classList.add('message', 'receiver-message');
                    responseElement.innerHTML = `
                        <div class="message-content">
                            <img src="media/logo.jpg" alt="SafeBrowse" class="bot-avatar">
                            <div class="message-text">
                                SB:<br>
                            </div>
                        </div>
                    `;
                    
                    // Add the response element to the chat messages container
                    messageWrapper.appendChild(responseElement);
                    
                    // Apply typing effect to the message text
                    const messageTextElement = responseElement.querySelector('.message-text');
                    typeMessage(messageTextElement, botResponse);
                    
                    // Scroll to bottom after adding bot response
                    scrollToBottom();
                } catch (error) {
                    // Only display error if it's not an abort error
                    if (error.name !== 'AbortError') {
                        console.error('Error:', error);
                        
                        // Remove the loading message
                        messageWrapper.removeChild(loadingElement);
                        
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('message', 'error-message');
                        errorElement.innerHTML = `
                            <div class="message-content">
                                <div class="message-text">
                                    Error: ${error.message || 'Unable to get response from the AI.'}
                                </div>
                            </div>
                        `;
                        messageWrapper.appendChild(errorElement);
                        
                        // Scroll to bottom after adding error message
                        scrollToBottom();
                    }
                    
                    // Reset the send button
                    resetSendButton();
                }
            }

            // Attach the submit handler to the form
            document.getElementById('chatForm').addEventListener('submit', handleSubmit);

            // File handling
            const fileInput = document.getElementById('fileInput');
            const imageInput = document.getElementById('imageInput');
            const audioInput = document.getElementById('audioInput');

            // Attachment button functionality
            const attachBtn = document.querySelector('.attach-btn');
            const attachmentOptions = document.querySelector('.attachment-options');

            attachBtn.addEventListener('click', () => {
                attachmentOptions.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
                if (!attachBtn.contains(e.target) && !attachmentOptions.contains(e.target)) {
                    attachmentOptions.classList.remove('show');
                }
            });

            const attachmentOptionBtns = document.querySelectorAll('.attachment-option');
            attachmentOptionBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const type = btn.dataset.type;
                    if (type === 'file') {
                        fileInput.click();
                    } else if (type === 'image') {
                        imageInput.click();
                    } else if (type === 'audio') {
                        audioInput.click();
                    }
                    attachmentOptions.classList.remove('show');
                });
            });

            fileInput.addEventListener('change', handleFileUpload);
            imageInput.addEventListener('change', handleImageUpload);
            audioInput.addEventListener('change', handleAudioUpload);

            async function handleFileUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = async (e) => {
                    const fileContent = e.target.result;
                    await sendFileToAI(file.name, fileContent);
                };
                reader.readAsText(file);
            }

            async function handleImageUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = async (e) => {
                    const imageContent = e.target.result;
                    await sendImageToAI(file.name, imageContent);
                };
                reader.readAsDataURL(file);
            }

            async function handleAudioUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

                // Show loading message
                const messageWrapper = document.querySelector('.message-wrapper');
                const loadingElement = document.createElement('div');
                loadingElement.classList.add('message', 'sender-message');
                loadingElement.innerHTML = `
                    <div class="message-content">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-lop2WBke5jRLJead2R60matgDD3rJf.png" alt="User" class="user-avatar">
                        <div class="message-text">
                            YOU:<br>Sent an audio file: ${file.name} (Processing...)
                        </div>
                    </div>
                `;
                messageWrapper.appendChild(loadingElement);
                scrollToBottom();

                try {
                    const reader = new FileReader();
                    reader.onload = async (e) => {
                        const audioContent = e.target.result;
                        await sendAudioToAI(file.name, audioContent);
                        
                        // Update the loading message
                        loadingElement.innerHTML = `
                            <div class="message-content">
                                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-lop2WBke5jRLJead2R60matgDD3rJf.png" alt="User" class="user-avatar">
                                <div class="message-text">
                                    YOU:<br>Sent an audio file: ${file.name}
                                </div>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                } catch (error) {
                    console.error('Error processing audio:', error);
                    loadingElement.innerHTML = `
                        <div class="message-content">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-lop2WBke5jRLJead2R60matgDD3rJf.png" alt="User" class="user-avatar">
                            <div class="message-text">
                                YOU:<br>Failed to process audio file: ${file.name}
                            </div>
                        </div>
                    `;
                    displayErrorMessage(error);
                }
            }

            async function sendFileToAI(fileName, fileContent) {
                try {
                    const message = `Please review this file: ${fileName}\n\nFile content:\n${fileContent}`;
                    await sendMessageToAI(message, `Sent a file: ${fileName}`);
                } catch (error) {
                    console.error('Error sending file to AI:', error);
                    displayErrorMessage(error);
                }
            }

            async function sendImageToAI(fileName, imageContent) {
                try {
                    const message = `Please analyze this image: ${fileName}`;
                    const requestBody = {
                        contents: [
                            {
                                parts: [
                                    { text: message },
                                    { inline_data: { mime_type: "image/jpeg", data: imageContent.split(',')[1] } }
                                ]
                            }
                        ]
                    };
                    await sendRequestToAI(requestBody, `Sent an image: ${fileName}`);
                } catch (error) {
                    console.error('Error sending image to AI:', error);
                    displayErrorMessage(error);
                }
            }

            async function sendAudioToAI(fileName, audioContent) {
                try {
                    // Extract base64 data from the data URL
                    const base64Data = audioContent.split(',')[1];
                    
                    // Determine the MIME type from the data URL
                    const mimeType = audioContent.match(/data:(.*?);/)[1] || "audio/mpeg";
                    
                    const message = `Please analyze this audio file: ${fileName}. Identify any harmful content, misinformation, or concerning elements in the audio.`;
                    
                    // Create request body with audio data
                    const requestBody = {
                        contents: [
                            {
                                parts: [
                                    { text: message },
                                    { inline_data: { mime_type: mimeType, data: base64Data } }
                                ]
                            }
                        ]
                    };
                    
                    // Add to chat history
                    chatState.history.push({ 
                        role: 'user', 
                        content: `[Uploaded audio file: ${fileName}] ${message}` 
                    });
                    
                    // Send to AI
                    await sendRequestToAI(requestBody, `Sent an audio file: ${fileName}`);
                } catch (error) {
                    console.error('Error sending audio to AI:', error);
                    displayErrorMessage(error);
                }
            }

            async function sendMessageToAI(message, displayMessage) {
                chatState.history.push({ role: 'user', content: message });
                const requestBody = {
                    contents: [
                        {
                            parts: [
                                { text: chatState.history.map(msg => `${msg.role}: ${msg.content}`).join('\n') }
                            ]
                        }
                    ]
                };
                await sendRequestToAI(requestBody, displayMessage);
            }

            async function sendRequestToAI(requestBody, displayMessage) {
                if (isGenerating) return; // Prevent multiple requests
                
                // Create a new message element for the file/image/audio
                const messageElement = document.createElement('div');
                messageElement.classList.add('message', 'sender-message');
                messageElement.innerHTML = `
                    <div class="message-content">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-lop2WBke5jRLJead2R60matgDD3rJf.png" alt="User" class="user-avatar">
                        <div class="message-text">
                            YOU:<br>${displayMessage}
                        </div>
                    </div>
                `;

                // Add the message element to the chat messages container
                const messageWrapper = document.querySelector('.message-wrapper');
                messageWrapper.appendChild(messageElement);
                
                // Scroll to bottom after adding user message
                scrollToBottom();
                
                // Create loading message with typing effect
                const loadingElement = document.createElement('div');
                loadingElement.classList.add('message', 'receiver-message', 'loading-message');
                loadingElement.innerHTML = `
                    <div class="message-content">
                        <img src="media/logo.jpg" alt="SafeBrowse" class="bot-avatar">
                        <div class="message-text">
                            SB:<br>Thinking<span class="loading-dots"></span>
                        </div>
                    </div>
                `;
                
                // Add the loading message to the chat
                messageWrapper.appendChild(loadingElement);
                scrollToBottom();
                
                // Convert send button to stop button
                convertToStopButton();

                console.log('Request body:', JSON.stringify(requestBody, null, 2));
                
                // Create an AbortController to be able to cancel the fetch
                currentController = new AbortController();
                const signal = currentController.signal;

                try {
                    // Generate response
                    const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${API_KEY}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(requestBody),
                        signal: signal
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                    }

                    const result = await response.json();
                    console.log('API response:', JSON.stringify(result, null, 2));

                    if (!result.candidates || result.candidates.length === 0) {
                        throw new Error('No response generated from the AI.');
                    }

                    const botResponse = result.candidates[0].content.parts[0].text;

                    // Add bot response to history
                    chatState.history.push({ role: 'assistant', content: botResponse });
                    
                    // Remove the loading message
                    messageWrapper.removeChild(loadingElement);

                    // Create and add bot response element
                    const responseElement = document.createElement('div');
                    responseElement.classList.add('message', 'receiver-message');
                    responseElement.innerHTML = `
                        <div class="message-content">
                            <img src="media/logo.jpg" alt="SafeBrowse" class="bot-avatar">
                            <div class="message-text">
                                SB:<br>
                            </div>
                        </div>
                    `;
                    
                    // Add the response element to the chat messages container
                    messageWrapper.appendChild(responseElement);
                    
                    // Apply typing effect to the message text
                    const messageTextElement = responseElement.querySelector('.message-text');
                    typeMessage(messageTextElement, botResponse);
                    
                    // Scroll to bottom after adding bot response
                    scrollToBottom();
                } catch (error) {
                    // Only display error if it's not an abort error
                    if (error.name !== 'AbortError') {
                        console.error('Error:', error);
                        
                        // Remove the loading message
                        messageWrapper.removeChild(loadingElement);
                        
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('message', 'error-message');
                        errorElement.innerHTML = `
                            <div class="message-content">
                                <div class="message-text">
                                    Error: ${error.message || 'Unable to get response from the AI.'}
                                </div>
                            </div>
                        `;
                        messageWrapper.appendChild(errorElement);
                        
                        // Scroll to bottom after adding error message
                        scrollToBottom();
                    }
                    
                    // Reset the send button
                    resetSendButton();
                }
            }

            function displayErrorMessage(error) {
                const errorElement = document.createElement('div');
                errorElement.classList.add('message', 'error-message');
                errorElement.innerHTML = `
                    <div class="message-content">
                        <div class="message-text">
                            Error: ${error.message || 'Unable to get response from the AI.'}
                        </div>
                    </div>
                `;
                const messageWrapper = document.querySelector('.message-wrapper');
                messageWrapper.appendChild(errorElement);
                
                // Scroll to bottom after adding error message
                scrollToBottom();
            }

            // Add fade-in effect to main content
            document.addEventListener('DOMContentLoaded', function() {
                const fadeElements = document.querySelectorAll('.fade-in');
                fadeElements.forEach((element, index) => {
                    setTimeout(() => {
                        element.style.opacity = '1';
                    }, index * 200);
                });
            });
            
            // Helper function to scroll chat to bottom
            function scrollToBottom() {
                const chatMessages = document.querySelector('.chat-messages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        </script>
    </body>
    </html>
