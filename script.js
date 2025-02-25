import { GoogleGenerativeAI } from '@google/generative-ai';
import * as readline from 'node:readline/promises';

const API_KEY = "modified"; 

const genAI = new GoogleGenerativeAI(API_KEY);



    let history = [];

    console.log("Bot: Hello, how can I help you?");

    const rl = readline.createInterface({
        input: process.stdin,
        output: process.stdout,
    });

    const promptUser = async () => {
        try {
            const userInput = await rl.question('You: ');

            const messages = history.map(turn => ({
                role: turn.role,
                parts: turn.parts.map(part => ({ text: part.text }))
            }));

            // Add user input
            messages.push({ role: "user", parts: [{ text: userInput }] });

            // Generate response
            const result = await model.generateContent({ contents: messages });

            const modelResponse = result.response.text(); // Extract response text

            console.log(`Bot: ${modelResponse}\n`);

            // Store conversation history
            history.push({ role: 'user', parts: [{ text: userInput }] });
            history.push({ role: 'model', parts: [{ text: modelResponse }] });

            promptUser();
        } catch (error) {
            console.error("Error during conversation:", error);
            rl.close();
        }
    };

    promptUser();
}

runChat();