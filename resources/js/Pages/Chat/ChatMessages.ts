import { Message } from '@/Types/Chat';  
import { getToLocaleTimeString } from '@/Functions/TimeStamp';

/**
 * @description Get messages which will be displayed in the chat and the type of sender might be user or system
 * @param id 
 * @param sender 
 * @param message 
 * @returns 
 */
export const getMessages = (id:number, sender: 'user' | 'system', message: string): Message => {
    return {
        id:id,
        text:message,
        sender:sender,
        timestamp: getToLocaleTimeString()
    }
}

/**
 * @description Speak the message which is the build-in standard function in browser
 * @param message
 * @returns void
 */
export const speak = (message: string) => {
    if ('speechSynthesis' in window) {
      const utterance = new SpeechSynthesisUtterance(message);
      window.speechSynthesis.speak(utterance);
    } else {
      console.warn("このブラウザはテキスト読み上げ機能をサポートしていません。");
    }
  };
  