let messageCount = 0;
const MAX_MESSAGES = 4;
const submitBtn = document.getElementById('submitBtn');
const messageLimitNotification = document.getElementById('messageLimitNotification');

// Variable to store the current fetch controller for aborting requests
let currentController = null;
let isGenerating = false;

function scrollToAbout() {
    window.location.href = "page1.html";
    window.location.hash = "#about";
}

// Replace the Google AI initialization code with this:
const API_KEY = "AIzaSyCqc3zIUa59r7UvNbn7gy6rhRXbsZ6NcxE";

async function initializeChat() {
    const history = [];
    const systemInstruction = "Your name is SafeBrowse. You are an AI agent responsible for detecting and recognizing harmful content, including misinformation, hate speech, and cyberbullying, from given data. You should highlight such content, provide corrections, and suggest appropriate actions accordingly. You were made by the team 404 fixers. If data has been given with the intention not related to your main mission, you should just explain why it's not from your expertise. Also, tell about yourself only when asked.";

    // Add system instruction to history
    history.push({ role: 'system', content: systemInstruction });

    return { history };
}

let chatState;

// Initialize chat when the page loads
window.addEventListener('load', async () => {
    chatState = await initializeChat();
    
    // Add responsive handling for window resize
    handleWindowResize();
    window.addEventListener('resize', handleWindowResize);
    
    // Add fade-in effect to main content
    const fadeElements = document.querySelectorAll('.fade-in');
    fadeElements.forEach((element, index) => {
        setTimeout(() => {
            element.style.opacity = '1';
        }, index * 200);
    });
});

// Function to handle window resize for better responsiveness
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

// Function to check and update message limit
function checkMessageLimit() {
    messageCount++;
    if (messageCount >= MAX_MESSAGES) {
        submitBtn.disabled = true;
        messageLimitNotification.style.display = 'block';
        document.getElementById('chatInput').placeholder = "Message limit reached";
    }
}

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
                <img src="Images/logo.jpg" alt="SafeBrowse" class="bot-avatar">
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
    
    // Check message limit before sending
    if (messageCount >= MAX_MESSAGES) {
        displayErrorMessage(new Error("Message limit reached. You cannot send more messages."));
        return;
    }
    
    const message = document.getElementById('chatInput').value;
    if (!message.trim()) return; // Don't submit empty messages
    
    document.querySelector('.main-title').style.display = 'none';
    document.querySelector('.subtitle').style.display = 'none';
    
    document.querySelector('.chat-background').style.display = 'block';
    
    // Adjust main height for better mobile experience
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
    
    // Scroll to bottom after adding user message
    scrollToBottom();

    // Clear input after sending
    document.getElementById('chatInput').value = ''; 
    
    // Increment message count and check limit
    checkMessageLimit();
    
    // Create loading message with typing effect
    const loadingElement = document.createElement('div');
    loadingElement.classList.add('message', 'receiver-message', 'loading-message');
    loadingElement.innerHTML = `
        <div class="message-content">
            <img src="Images/logo.jpg" alt="SafeBrowse" class="bot-avatar">
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
        chatState.history.push({ role: 'SafeBrowse', content: botResponse });

        // Remove the loading message
        messageWrapper.removeChild(loadingElement);
        
        // Create and add bot response element
        const responseElement = document.createElement('div');
        responseElement.classList.add('message', 'receiver-message');
        responseElement.innerHTML = `
            <div class="message-content">
                <img src="Images/logo.jpg" alt="SafeBrowse" class="bot-avatar">
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

// Helper function to scroll chat to bottom - improved for better scrolling
function scrollToBottom() {
    const chatMessages = document.querySelector('.chat-messages');
    if (chatMessages) {
        // Use requestAnimationFrame for smoother scrolling
        requestAnimationFrame(() => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }
}

// Add event listener for form submission
document.getElementById('chatForm').addEventListener('submit', handleSubmit);

// Add a "New chat" functionality to reset the chat
function resetChat() {
    messageCount = 0;
    submitBtn.disabled = false;
    messageLimitNotification.style.display = 'none';
    document.getElementById('chatInput').placeholder = "Type your message...";
    
    // Clear chat messages
    document.querySelector('.message-wrapper').innerHTML = '';
    
    // Reset chat state
    initializeChat().then(state => {
        chatState = state;
    });
    
    // Show main title and subtitle
    document.querySelector('.main-title').style.display = 'block';
    document.querySelector('.subtitle').style.display = 'block';
    document.querySelector('.chat-background').style.display = 'none';
}