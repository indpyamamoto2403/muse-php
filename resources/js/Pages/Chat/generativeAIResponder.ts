import axios from 'axios';

export async function getAIResponse(_message: string, conversationHistory: string): Promise<string> {

    // 生成AIのAPIエンドポイント
    const endpoint = '/api/chat';
    const response = await axios.post(endpoint, {
      message: _message,
      conversationHistory: conversationHistory
    });

    const message = response.data.message;
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(message);
      }, 100);
    });
  }

export async function getScore(conversationHistory: string): Promise<string> {
  
    // 生成AIのAPIエンドポイント
    const endpoint = '/api/chat/all';
    const response = await axios.post(endpoint, {
      conversationHistory: conversationHistory
    });

    const message = response.data.message;
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(message);
      }, 100);
    });
  }