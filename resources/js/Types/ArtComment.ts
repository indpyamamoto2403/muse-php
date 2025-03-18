import { User } from './User';

export interface ArtComment {
    art_id: number;
    comment: string;
    created_at: string; // ISO8601形式の文字列
    id: number;
    updated_at: string; // ISO8601形式の文字列
    user: User;
    user_id: number;
  }