import type { ToolCategory } from '@/types/landing';

export const toolCategories: ToolCategory[] = [
    { title: 'Text Tools', description: 'Write, count, and transform', icon: 'text', id: 'text-tools' },
    { title: 'PDF Tools', description: 'Manage and edit documents', icon: 'file', id: 'pdf-tools' },
    { title: 'Image Tools', description: 'Resize and convert images', icon: 'image', id: 'image-tools' },
    { title: 'File Converter', description: 'Switch between file formats', icon: 'files', id: 'file-converter' },
    { title: 'Video Tools', description: 'Work with video files', icon: 'video', id: 'video-tools' },
    { title: 'Audio Tools', description: 'Convert and shape audio', icon: 'audio', id: 'audio-tools' },
    { title: 'Developer Tools', description: 'Format and inspect code', icon: 'code', id: 'developer-tools' },
    { title: 'Utilities', description: 'Small helpers for everyday tasks', icon: 'zap', id: 'utilities' },
];
