import axios from 'axios';

export async function fetchAIResponse(_message: string, conversationHistory: string): Promise<string> {

    // 生成AIのAPIエンドポイント
    const endpoint = '/api/chat';
    const response = await axios.post(endpoint, {
      message: _message,
      conversationHistory: conversationHistory
    });

    const message = response.data.message;
    const audioURL = response.data.audioURL;
    const audio = new Audio(audioURL);
    audio.play();
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(message);
      }, 500);
    });
  }

export async function fetchScore(conversationHistory: string): Promise<void> {
  
  // 生成AIのAPIエンドポイント
  const endpoint = '/api/chat/all';
  const response = await axios.post(endpoint, {
    conversationHistory: conversationHistory
  });

  const message = response.data.message;
  return new Promise((resolve) => {
    setTimeout(() => {
    window.location.href = '/chat/complete';
    resolve();
    }, 5000);
  });
  }