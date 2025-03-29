if (window.pdfjsLib) {
    window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';
}

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

const API_KEY = "AIzaSyCqc3zIUa59r7UvNbn7gy6rhRXbsZ6NcxE";

// Variable to store the current fetch controller for aborting requests
let currentController = null;

// Copy to clipboard functionality
function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => {
            showCopySuccess();
        })
        .catch(err => {
            console.error('Failed to copy text: ', err);
        });
}

function showCopySuccess() {
    // success message
    const successMsg = document.createElement('div');
    successMsg.textContent = 'Copied to clipboard!';
    successMsg.className = 'copy-success-message';
    document.body.appendChild(successMsg);
    
    // Remove after 2 seconds
    setTimeout(() => {
        successMsg.remove();
    }, 2000);
}

async function initializeChat() {
    const history = [];
    const systemInstruction = "Your name is SafeBrowse. You are an AI agent responsible for detecting and recognizing all types of harmful content from whatever user provide. You should highlight such content, provide corrections, and suggest appropriate actions accordingly. You were made by the team 404 fixers. If data has been given with the intention not related to your main mission, you should just explain why it's not from your expertise. Also, tell about yourself only when asked.";

    // system instruction to history
    history.push({ role: 'SafeBrowse', content: systemInstruction });

    return { history };
}

let chatState;
let isGenerating = false;

// Initialize chat when the page loads
window.addEventListener('load', async () => {
    chatState = await initializeChat();
    
    // Add responsive handling for window resize
    handleWindowResize();
    window.addEventListener('resize', handleWindowResize);
    
    const fadeElements = document.querySelectorAll('.fade-in');
    fadeElements.forEach((element, index) => {
        setTimeout(() => {
            element.style.opacity = '1';
        }, index * 200);
    });
});

function handleWindowResize() {
    const isMobile = window.innerWidth <= 768;
    const chatBackground = document.querySelector('.chat-background');
    
    if (chatBackground && chatBackground.style.display !== 'none') {
        if (isMobile) {
            document.querySelector('.main').style.height = '100vh';
        } else {
            document.querySelector('.main').style.height = '20em';
        }
    }
}

function typeMessage(element, text, speed = 30) {
    let i = 0;
    element.innerHTML = 'SB:<br>'; 
    
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
            
            // Add copy button after typing is complete
            const messageContent = element.closest('.message-content');
            if (messageContent && !messageContent.querySelector('.copy-btn')) {
                const copyBtn = document.createElement('button');
                copyBtn.className = 'copy-btn';
                copyBtn.setAttribute('aria-label', 'Copy to clipboard');
                copyBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                `;
                
                // Store the full text for copying 
                const fullText = text;
                
                copyBtn.addEventListener('click', () => {
                    copyToClipboard(fullText);
                });
                
                messageContent.appendChild(copyBtn);
            }
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
    
    // 0button event listener
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
                <i class="fa-solid fa-circle-user fa-2x"></i>     
                <div class="message-text">
                    SB:<br>Response generation stopped.
                </div>
            </div>
        `;
    }
}

// Function to handle submit button
async function handleSubmit(e) {
    if (e) e.preventDefault();
    if (isGenerating) return; // Prevent multiple submissions
    
    const message = document.getElementById('chatInput').value;
    if (!message.trim()) return; // prevent empty messages
    
    document.querySelector('.main-title').style.display = 'none';
    document.querySelector('.subtitle').style.display = 'none';
    document.querySelector('.chat-background').style.display = 'block';
    
    handleWindowResize();

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

        chatState.history.push({ role: 'SafeBrowse', content: botResponse });

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
        
        scrollToBottom();
    } catch (error) {
        // Only display error if it's not an abort error
        if (error.name !== 'AbortError') {
            console.error('Error:', error);
            
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
            document.querySelector('.main-title').style.display = 'none';
            document.querySelector('.subtitle').style.display = 'none';
            document.querySelector('.chat-background').style.display = 'block';
        } else if (type === 'image') {
            imageInput.click();
            document.querySelector('.main-title').style.display = 'none';
            document.querySelector('.subtitle').style.display = 'none';
            document.querySelector('.chat-background').style.display = 'block';
        } else if (type === 'audio') {
            // Show audio recorder instead of file input
            showAudioRecorder();
            document.querySelector('.main-title').style.display = 'none';
            document.querySelector('.subtitle').style.display = 'none';
            document.querySelector('.chat-background').style.display = 'block';
        }
        attachmentOptions.classList.remove('show');
    });
});

fileInput.addEventListener('change', handleFileUpload);
imageInput.addEventListener('change', handleImageUpload);
audioInput.addEventListener('change', handleAudioUpload);

// Helper function to get file type icon
function getFileTypeIcon(fileName) {
    const extension = fileName.split('.').pop().toLowerCase();
    let iconClass = 'txt';
    
    if (extension === 'pdf') {
        iconClass = 'pdf';
    } else if (['ppt', 'pptx'].includes(extension)) {
        iconClass = 'ppt';
    } else if (['doc', 'docx'].includes(extension)) {
        iconClass = 'doc';
    }
    
    return `<span class="file-icon ${iconClass}">${extension.toUpperCase()}</span>`;
}

// Function to extract text from DOCX files
async function extractTextFromDOCX(arrayBuffer) {
    try {
        if (!window.mammoth) {
            console.error("Mammoth.js library not loaded");
            return "Error: Text extraction library not loaded. Please refresh the page.";
        }
        
        const result = await window.mammoth.extractRawText({ arrayBuffer });
        return result.value;
    } catch (error) {
        console.error("Error extracting DOCX text:", error);
        return "Error extracting text from DOCX file: " + error.message;
    }
}

// <---- EXTRACTION SECTION ---->
// Function to extract text from PDF files
async function extractTextFromPDF(arrayBuffer) {
    try {
        if (!window.pdfjsLib) {
            console.error("PDF.js library not loaded");
            return "Error: PDF extraction library not loaded. Please refresh the page.";
        }
        
        const pdf = await window.pdfjsLib.getDocument({ data: arrayBuffer }).promise;
        let text = "";
        
        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            const content = await page.getTextContent();
            const pageText = content.items.map(item => item.str).join(" ");
            text += pageText + "\n\n";
        }
        
        return text;
    } catch (error) {
        console.error("Error extracting PDF text:", error);
        return "Error extracting text from PDF file: " + error.message;
    }
}

// ppt & error handling 
async function extractTextFromPPTX(arrayBuffer) {
    try {
        if (!window.JSZip) {
            console.error("JSZip library not loaded");
            return "Error: PPTX extraction library not loaded. Please refresh the page.";
        }
        
        const zip = await window.JSZip.loadAsync(arrayBuffer);
        let text = "";
        
        // PPTX files store slide content in ppt/slides/slide*.xml files
        const slideFiles = Object.keys(zip.files).filter(name => 
            name.startsWith("ppt/slides/slide") && name.endsWith(".xml")
        );
        
        for (const slideFile of slideFiles) {
            const content = await zip.file(slideFile).async("string");
            // Extract text from XML 
            const textMatches = content.match(/<a:t>([^<]*)<\/a:t>/g) || [];
            const slideText = textMatches
                .map(match => match.replace(/<a:t>|<\/a:t>/g, ""))
                .join(" ");
            
            text += "Slide " + slideFile.match(/slide(\d+)/)[1] + ":\n" + slideText + "\n\n";
        }
        
        return text || "No text content found in PPTX file";
    } catch (error) {
        console.error("Error extracting PPTX text:", error);
        return "Error extracting text from PPTX file: " + error.message;
    }
}

// Function to extract text from DOC files
async function extractTextFromDOC(arrayBuffer) {
    const uint8Array = new Uint8Array(arrayBuffer);
    let text = "";
    
    // text chunks in the binary data
    for (let i = 0; i < uint8Array.length; i++) {
        if (uint8Array[i] >= 32 && uint8Array[i] <= 126) {
            text += String.fromCharCode(uint8Array[i]);
        } else if (uint8Array[i] === 13 || uint8Array[i] === 10) {
            text += "\n";
        }
    }
    
    // removing non word sequence
    text = text.replace(/[^\w\s.,;:!?'"()\[\]{}\-–—]/g, " ")
            .replace(/\s+/g, " ")
            .trim();
    
    return text || "Limited text extraction from DOC file. Consider converting to DOCX for better results.";
}

// Main function to handle file extraction based on type
async function extractTextFromFile(file) {
    const arrayBuffer = await file.arrayBuffer();
    const fileExtension = file.name.split('.').pop().toLowerCase();
    
    console.log(`Extracting text from ${fileExtension.toUpperCase()} file: ${file.name}`);
    
    switch (fileExtension) {
        case 'docx':
            return extractTextFromDOCX(arrayBuffer);
        case 'doc':
            return extractTextFromDOC(arrayBuffer);
        case 'pptx':
            return extractTextFromPPTX(arrayBuffer);
        case 'ppt':
            return "PPT files (older PowerPoint format) have limited support. Consider converting to PPTX for better results.";
        case 'pdf':
            return extractTextFromPDF(arrayBuffer);
        case 'txt':
            return new TextDecoder().decode(arrayBuffer);
        default:
            return `Unsupported file type: ${fileExtension}`;
    }
}

// File upload handler that works with binary files
async function handleFileUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Show the chat interface
    document.querySelector('.main-title').style.display = 'none';
    document.querySelector('.subtitle').style.display = 'none';
    document.querySelector('.chat-background').style.display = 'block';
    
    // Create a message element for the file upload with progress indicator
    const messageWrapper = document.querySelector('.message-wrapper');
    const uploadElement = document.createElement('div');
    uploadElement.classList.add('message', 'sender-message');
    
    const fileIcon = getFileTypeIcon(file.name);
    
    uploadElement.innerHTML = `
        <div class="message-content">
            <i class="fa-solid fa-circle-user fa-2x"></i>

            <div class="message-text">
                YOU:<br>Uploading file: ${fileIcon} ${file.name} (${(file.size / 1024).toFixed(1)} KB)
                <div class="file-progress">
                    <div class="file-progress-bar"></div>
                </div>
            </div>
        </div>
    `;
    
    messageWrapper.appendChild(uploadElement);
    scrollToBottom();
    
    const progressBar = uploadElement.querySelector('.file-progress-bar');
    progressBar.style.width = '30%';
    
    try {
        // Determine how to handle the file based on its type
        const fileExtension = file.name.split('.').pop().toLowerCase();
        
        // Update progress
        progressBar.style.width = '60%';
        
        let fileContent;
        
        if (['doc', 'docx', 'ppt', 'pptx', 'pdf'].includes(fileExtension)) {
            // Extract text using our new functions
            fileContent = await extractTextFromFile(file);
            
            // Update progress
            progressBar.style.width = '100%';
            
            uploadElement.innerHTML = `
                <div class="message-content">
                    <i class="fa-solid fa-circle-user fa-2x"></i>
                    <div class="message-text">
                        YOU:<br>Sent a file: ${fileIcon} ${file.name}
                    </div>
                </div>
            `;
            
            // Send the extracted text to the AI
            const message = `Please review this ${fileExtension.toUpperCase()} file: ${file.name}\n\nExtracted content:\n${fileContent}`;
            await sendMessageToAI(message, `Sent a file: ${fileIcon} ${file.name}`);
        } else if (fileExtension === 'txt') {
            // For text files, use the text reader
            await readFileAsText(file, progressBar, uploadElement);
        } else {
            const reader = new FileReader();
            
            reader.onprogress = (event) => {
                if (event.lengthComputable) {
                    const progress = (event.loaded / event.total) * 100;
                    progressBar.style.width = `${progress}%`;
                }
            };
            
            reader.onload = async (e) => {
                progressBar.style.width = '100%';
                
                uploadElement.innerHTML = `
                    <div class="message-content">
                        <i class="fa-solid fa-circle-user fa-2x"></i>

                        <div class="message-text">
                            YOU:<br>Sent a file: ${fileIcon} ${file.name}
                        </div>
                    </div>
                `;
                
                // Send a generic message for unsupported file types
                const message = `I've uploaded a file: ${file.name} (${fileExtension.toUpperCase()} format). Please analyze it if possible.`;
                await sendMessageToAI(message, `Sent a file: ${fileIcon} ${file.name}`);
            };
            
            reader.onerror = () => {
                throw new Error('Error reading the file');
            };
            
            reader.readAsArrayBuffer(file);
        }
    } catch (error) {
        console.error('Error processing file:', error);
        uploadElement.innerHTML = `
            <div class="message-content">
                <i class="fa-solid fa-circle-user fa-2x"></i>

                <div class="message-text">
                    YOU:<br>Failed to process file: ${file.name} - ${error.message}
                </div>
            </div>
        `;
        displayErrorMessage(error);
    }
}

// Function to read text files
async function readFileAsText(file, progressBar, uploadElement) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        
        reader.onprogress = (event) => {
            if (event.lengthComputable) {
                const progress = (event.loaded / event.total) * 100;
                progressBar.style.width = `${progress}%`;
            }
        };
        
        reader.onload = async (e) => {
            try {
                progressBar.style.width = '100%';
                const fileContent = e.target.result;
                
                const fileIcon = getFileTypeIcon(file.name);
                uploadElement.innerHTML = `
                    <div class="message-content">
                        <i class="fa-solid fa-circle-user fa-2x"></i>

                        <div class="message-text">
                            YOU:<br>Sent a file: ${fileIcon} ${file.name}
                        </div>
                    </div>
                `;
                
                // Send the text file content to the AI
                const message = `Please review this text file: ${file.name}\n\nFile content:\n${fileContent}`;
                await sendMessageToAI(message, `Sent a file: ${fileIcon} ${file.name}`);
                resolve();
            } catch (error) {
                reject(error);
            }
        };
        
        reader.onerror = () => {
            reject(new Error('Error reading the file'));
        };
        
        reader.readAsText(file);
    });
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

    try {
        const reader = new FileReader();
        reader.onload = async (e) => {
            const audioContent = e.target.result;
            await sendAudioToAI(file.name, audioContent);
            
            // Update the loading message
            loadingElement.innerHTML = `
                <div class="message-content">
                    <i class="fa-solid fa-circle-user fa-2x"></i>

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
                <i class="fa-solid fa-circle-user fa-2x"></i>             

                <div class="message-text">
                    YOU:<br>Failed to process audio file: ${file.name}
                </div>
            </div>
        `;
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
        
        const message = `Please analyze this audio file: ${fileName}`;
        
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
            <i class="fa-solid fa-circle-user fa-2x"></i>

            <div class="message-text">
                YOU:<br>${displayMessage}
            </div>
        </div>
    `;

    // Add the message element to the chat messages container
    const messageWrapper = document.querySelector('.message-wrapper');
    messageWrapper.appendChild(messageElement);
    
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

        chatState.history.push({ role: 'SafeBrowse', content: botResponse });
        
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
        
        scrollToBottom();
    } catch (error) {
        // Only display error if it's not an abort error
        if (error.name !== 'AbortError') {
            console.error('Error:', error);
            
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
            
            scrollToBottom();
        }
        
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
    
    scrollToBottom();
}

// function to scroll chat to bottom
function scrollToBottom() {
    const chatMessages = document.querySelector('.chat-messages');
    if (chatMessages) {
        // Use requestAnimationFrame for smoother scrolling
        requestAnimationFrame(() => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }
}

// Audio Recorder Functionality
let mediaRecorder;
let audioChunks = [];
let recordingTimer;
let recordingTime = 0;
let audioBlob;
let audioURL;
let audioStream;
let audioContext;
let analyser;

// Audio recorder UI elements
const audioRecorder = document.getElementById('audioRecorder');
const recorderOverlay = document.getElementById('recorderOverlay');
const closeRecorder = document.getElementById('closeRecorder');
const startRecording = document.getElementById('startRecording');
const stopRecording = document.getElementById('stopRecording');
const sendAudio = document.getElementById('sendAudio');
const audioPreview = document.getElementById('audioPreview');
const recordingStatus = document.getElementById('recordingStatus');
const recordingTimeDisplay = document.getElementById('recordingTime');

// audio recorder animation
function showAudioRecorder() {
    resetAudioRecorder();
    recorderOverlay.style.display = 'block';
    audioRecorder.style.display = 'block';
    
    // Trigger reflow for animation
    void audioRecorder.offsetWidth;
    
    // animation classes
    recorderOverlay.classList.add('show');
    audioRecorder.classList.add('show');
}

// Close audio recorder with animation
function closeAudioRecorder() {
    stopAudioRecording();
    
    // Remove animation classes
    recorderOverlay.classList.remove('show');
    audioRecorder.classList.remove('show');
    
    // Wait for animation to complete before hiding
    setTimeout(() => {
        audioRecorder.style.display = 'none';
        recorderOverlay.style.display = 'none';
    }, 300);
    
    // Clean up resources
    if (audioStream) {
        audioStream.getTracks().forEach(track => track.stop());
        audioStream = null;
    }
    
    if (audioContext) {
        audioContext.close().catch(err => console.error('Error closing audio context:', err));
        audioContext = null;
    }
    
    if (audioURL) {
        URL.revokeObjectURL(audioURL);
        audioURL = null;
    }
}

// Reset audio recorder
function resetAudioRecorder() {
    audioChunks = [];
    recordingTime = 0;
    audioBlob = null;
    audioURL = null;
    
    startRecording.style.display = 'block';
    stopRecording.style.display = 'none';
    sendAudio.style.display = 'none';
    audioPreview.style.display = 'none';
    audioPreview.src = '';
    recordingStatus.innerHTML = 'Ready to record';
    recordingTimeDisplay.textContent = '';
}

// Start audio recording
async function startAudioRecording() {
    try {
        resetAudioRecorder();
        
        // Request microphone access
        audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
        
        // Set up audio context for visualizer
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const source = audioContext.createMediaStreamSource(audioStream);
        analyser = audioContext.createAnalyser();
        analyser.fftSize = 256;
        source.connect(analyser);
        
        // Create media recorder
        mediaRecorder = new MediaRecorder(audioStream);
        
        mediaRecorder.ondataavailable = (event) => {
            if (event.data.size > 0) {
                audioChunks.push(event.data);
            }
        };
        
        mediaRecorder.onstop = () => {
            // Create audio blob and URL
            audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
            audioURL = URL.createObjectURL(audioBlob);
            
            audioPreview.src = audioURL;
            audioPreview.style.display = 'block';
            sendAudio.style.display = 'block';
            recordingStatus.textContent = 'Recording complete';
            
            // Stop the timer
            clearInterval(recordingTimer);
        };
        
        // Start recording
        mediaRecorder.start();
        
        startRecording.style.display = 'none';
        stopRecording.style.display = 'block';
        recordingStatus.innerHTML = '<span class="recording-indicator"></span> Recording...';
        
        // Start timer
        recordingTime = 0;
        updateRecordingTime();
        recordingTimer = setInterval(updateRecordingTime, 1000);
        
    } catch (error) {
        console.error('Error starting audio recording:', error);
        recordingStatus.textContent = 'Error: ' + error.message;
    }
}

// Stop audio recording
function stopAudioRecording() {
    if (mediaRecorder && mediaRecorder.state === 'recording') {
        mediaRecorder.stop();
        
        // Stop all tracks
        if (audioStream) {
            audioStream.getTracks().forEach(track => track.stop());
        }
        
        // Clear timer
        clearInterval(recordingTimer);
    }
}

// Update recording time display
function updateRecordingTime() {
    recordingTime++;
    const minutes = Math.floor(recordingTime / 60);
    const seconds = recordingTime % 60;
    recordingTimeDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

// Send recorded audio
async function sendRecordedAudio() {
    if (!audioBlob) return;
    
    try {
        // Convert blob to base64
        const reader = new FileReader();
        reader.onload = async (e) => {
            const base64Audio = e.target.result;
            
            // Generate a filename with timestamp
            const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
            const fileName = `recording-${timestamp}.webm`;
            
            // Send to AI
            await sendAudioToAI(fileName, base64Audio);
            
            // Close recorder
            closeAudioRecorder();
        };
        reader.readAsDataURL(audioBlob);
    } catch (error) {
        console.error('Error sending recorded audio:', error);
        recordingStatus.textContent = 'Error: ' + error.message;
    }
}

// Event listeners for audio recorder
closeRecorder.addEventListener('click', closeAudioRecorder);
recorderOverlay.addEventListener('click', (e) => {
    // overley clikcing closes the recorder
    if (e.target === recorderOverlay) {
        closeAudioRecorder();
    }
});
startRecording.addEventListener('click', startAudioRecording);
stopRecording.addEventListener('click', stopAudioRecording);
sendAudio.addEventListener('click', sendRecordedAudio);