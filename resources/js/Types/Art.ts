
export interface Art {
    id: number;            // もしUUIDなら string に変更
    user_id: number;       
    title: string;
    description: string;         
    image_url: string;
  }