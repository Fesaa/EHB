export type ChatInfo = {
    id: string;
    name: string;
}

export type ChatMessage = {
    user: boolean;
    text: string;
}

export type FullChatInfo = {
    id: string;
    name: string;
    chatHistory: ChatMessage[];
}
