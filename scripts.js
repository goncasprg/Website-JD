// scripts.js

document.getElementById('startChat').addEventListener('click', () => {
    document.getElementById('chat-section').style.display = 'block';
});

document.getElementById('send-message').addEventListener('click', () => {
    let userInput = document.getElementById('user-input').value;
    if (userInput) {
        let userMessage = document.createElement('div');
        userMessage.textContent = `Você: ${userInput}`;
        document.getElementById('chat-log').appendChild(userMessage);

        // Simulando resposta da IA
        setTimeout(() => {
            let aiMessage = document.createElement('div');
            aiMessage.textContent = `IA: Eu sou uma IA, como posso te ajudar?`;
            document.getElementById('chat-log').appendChild(aiMessage);
        }, 1000);

        // Limpar campo de input
        document.getElementById('user-input').value = '';
    }
});
