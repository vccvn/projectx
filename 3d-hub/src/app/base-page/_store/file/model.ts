export interface MediaFile {
  quanlity?: EMediaFileQuanlity;
  width?: number;
  height?: number;
  bucket?: string;
  url?: string;
  key?: string;
  isWatermark?: boolean;
}

export interface FontFile {
  format?: EFontFormat;
  style?: EFontStyle;
  key?: string;
  name: string;
  bucket?: string;
  url?: string;
  thumbnail?: string;
}

export enum EFontFormat {
  ttf = 'ttf',
  woff = 'woff',
}

export enum EFontStyle {
  regular = 'Regular',
  italic = 'Italic',
  bold = 'Bold',
}

export enum EMediaFileType {
  vector = 'vector',
  raster = 'raster',
}

export enum EMediaFileQuanlity {
  thumbnail = 'thumbnail',
  screen = 'screen',
  original = 'original',
  printNormal = 'print_normal',
  printHigh = 'print_high',
}
