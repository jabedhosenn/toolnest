import http from '@/services/http';
import type {
    ApiResource,
    ApiResourceCollection,
    CategoryDirectoryResource,
    ToolListFilters,
    ToolDirectoryResource,
} from '@/types/api';
import type { IconName, Tool, ToolCategory } from '@/types/landing';

const iconNames: IconName[] = [
    'arrow-down',
    'arrow-right',
    'arrow-up-right',
    'audio',
    'check',
    'chevron-down',
    'clock',
    'code',
    'file',
    'files',
    'grid',
    'image',
    'menu',
    'moon',
    'search',
    'sparkles',
    'sun',
    'text',
    'upload',
    'video',
    'wand',
    'x',
    'zap',
];

function toIconName(icon: string): IconName {
    if (!iconNames.includes(icon as IconName)) {
        throw new Error(`Unsupported tool directory icon: ${icon}`);
    }

    return icon as IconName;
}

function toToolCategory(category: CategoryDirectoryResource): ToolCategory {
    return {
        title: category.name,
        description: category.description ?? '',
        icon: toIconName(category.icon),
        id: category.slug,
        slug: category.slug,
    };
}

function toTool(tool: ToolDirectoryResource, label?: string): Tool {
    return {
        id: tool.id,
        slug: tool.slug,
        title: tool.name,
        description: tool.description,
        category: tool.category.name,
        icon: toIconName(tool.icon),
        routeName: tool.route_name,
        componentIdentifier: tool.component_identifier,
        label,
    };
}

export async function fetchToolCategories(): Promise<ToolCategory[]> {
    const response = await http.get<ApiResource<CategoryDirectoryResource[]>>('/api/categories');

    return response.data.data.map(toToolCategory);
}

export async function fetchTools(filters: ToolListFilters = {}): Promise<ApiResourceCollection<Tool>> {
    const response = await http.get<ApiResourceCollection<ToolDirectoryResource>>('/api/tools', {
        params: filters,
    });

    return {
        ...response.data,
        data: response.data.data.map((tool) => toTool(tool)),
    };
}

export async function fetchTool(slug: string): Promise<Tool> {
    const response = await http.get<ApiResource<ToolDirectoryResource>>(`/api/tools/${encodeURIComponent(slug)}`);

    return toTool(response.data.data);
}

export async function fetchPopularTools(): Promise<Tool[]> {
    const response = await http.get<ApiResourceCollection<ToolDirectoryResource>>('/api/tools/popular');

    return response.data.data.map((tool) => toTool(tool));
}

export async function fetchFeaturedTools(): Promise<Tool[]> {
    const response = await http.get<ApiResourceCollection<ToolDirectoryResource>>('/api/tools/featured');

    return response.data.data.map((tool) => toTool(tool, 'Featured'));
}

export async function fetchRecentTools(): Promise<Tool[]> {
    const response = await http.get<ApiResourceCollection<ToolDirectoryResource>>('/api/tools', {
        params: {
            sort: 'recent',
            per_page: 4,
        },
    });

    return response.data.data.map((tool) => toTool(tool, 'New'));
}

export async function searchTools(query: string): Promise<Tool[]> {
    const response = await http.get<ApiResourceCollection<ToolDirectoryResource>>('/api/tools/search', {
        params: {
            q: query,
        },
    });

    return response.data.data.map((tool) => toTool(tool));
}
