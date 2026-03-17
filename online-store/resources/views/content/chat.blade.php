@extends('layouts.template')

@section('content')
    <div class="chat-page">

        <div class="chat-container">

            <div class="chat-header">
                🤖 Customer Support
            </div>

            <div class="chat-body" id="chatBody">

                <div class="message bot">
                    <div class="bubble">
                        Hello 👋 How can I help you today?
                    </div>
                </div>

            </div>

            <div class="chat-input">
                <input type="text" id="messageInput" placeholder="Type your message...">
                <button onclick="sendMessage()">Send</button>
            </div>

        </div>

    </div>
    <script>
        async function sendMessage(){

            let input = document.getElementById("messageInput");
            let message = input.value.trim();

            if(message === "") return;

            let chatBody = document.getElementById("chatBody");

            chatBody.innerHTML += `
                <div class="message user">
                    <div class="bubble">${message}</div>
                </div>
            `;

            input.value="";

            try{

                let response = await fetch("/chat/ask",{
                    method:"POST",
                    headers:{
                        "Content-Type":"application/json",
                        "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content
                    },
                    body:JSON.stringify({
                        message:message
                    })
                });

                let data = await response.json();

                chatBody.innerHTML += `
                    <div class="message bot">
                        <div class="bubble">${data.reply}</div>
                    </div>
                `;

                chatBody.scrollTop = chatBody.scrollHeight;

            }catch(error){

                console.error(error);

                chatBody.innerHTML += `
                    <div class="message bot">
                        <div class="bubble">Server error</div>
                    </div>
                `;
            }
        }
        document.getElementById("messageInput").addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                sendMessage();
            }
        });
    </script>
@endsection
