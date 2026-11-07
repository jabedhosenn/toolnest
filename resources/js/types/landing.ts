export type IconName =
    | 'arrow-down'
    | 'arrow-right'
    | 'arrow-up-right'
    | 'audio'
    | 'check'
    | 'chevron-down'
    | 'clock'
    | 'code'
    | 'file'
    | 'files'
    | 'grid'
    | 'image'
    | 'menu'
    | 'moon'
    | 'search'
    | 'sparkles'
    | 'sun'
    | 'text'
    | 'upload'
    | 'video'
    | 'wand'
    | 'x'
    | 'zap';

export interface Tool {
    title: string;
    description: string;
    category: string;
    icon: IconName;
    href?: string;
    label?: string;
}

export interface ToolCategory {
    title: string;
    description: string;
    icon: IconName;
    id: string;
}
