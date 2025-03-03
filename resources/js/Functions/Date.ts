
// 日付フォーマット
export function formatDate(dateString: string): string {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('ja-JP', {
      hour: '2-digit',
      minute: '2-digit',
    }).format(date);
  }