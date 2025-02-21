// ArtworkSliders.ts

/**
 * 1～5 の整数値のみ許容する型
 */
export type FiveScale = 1 | 2 | 3 | 4 | 5;

/**
 * スライダー9項目の数値を保持するインターフェース
 */
export interface Evaluation {
  /** 作風 (具象性～抽象性) */
  style: FiveScale;

  /** 伝統的～革新的 */
  traditionInnovation: FiveScale;

  /** 内省的～感情的 */
  introspectiveEmotional: FiveScale;

  /** 色彩感覚 (落ち着き～大胆) */
  colorSense: FiveScale;

  /** 構図 (静的～動的) */
  composition: FiveScale;

  /** 技法 (伝統的～革新的) */
  technique: FiveScale;

  /** テーマ性 (低い～高い) */
  theme: FiveScale;

  /** エネルギー (静的～動的) */
  energy: FiveScale;

  /** 全体の独自性・創造性 (伝統的～独創的) */
  uniqueness: FiveScale;
}

export interface Score {
  /** 作風 (具象性～抽象性) */
  style: number;

  /** 伝統的～革新的 */
  tradition_innovation: number;

  /** 内省的～感情的 */
  introspective_emotional: number;

  /** 色彩感覚 (落ち着き～大胆) */
  color_sense: number;

  /** 構図 (静的～動的) */
  composition: number;

  /** 技法 (伝統的～革新的) */
  technique: number;

  /** テーマ性 (低い～高い) */
  theme: number;

  /** エネルギー (静的～動的) */
  energy: number;

  /** 全体の独自性・創造性 (伝統的～独創的) */
  uniqueness: number;
}