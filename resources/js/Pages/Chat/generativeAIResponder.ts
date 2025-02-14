import axios from 'axios';

export async function getAIResponse(prompt: string, conversationHistory: string): Promise<string> {

    // 生成AIのAPIエンドポイント
    const endpoint = '/api/chat';
    const response = await axios.post(endpoint, {
      message: prompt,
      conversationHistory: conversationHistory
    });

    const message = response.data.message;
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(message);
      }, 100);
    });
  }