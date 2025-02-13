import axios from 'axios';

export async function getAIResponse(prompt: string): Promise<string> {

    // 生成AIのAPIエンドポイント
    const endpoint = '/api/chat';
    const response = await axios.post(endpoint, {
      message: prompt,
    });

    const message = response.data.message;
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(message);
      }, 100);
    });
  }