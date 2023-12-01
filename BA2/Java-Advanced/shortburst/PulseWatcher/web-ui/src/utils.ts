function formatRelativeTime(seconds: number): string {
    const minute = 60;
    const hour = 60 * minute;
    const day = 24 * hour;
    seconds = Math.floor(seconds);

    if (seconds < minute) {
        return `${seconds}s ago`;
    } else if (seconds < hour) {
        const minutes = Math.floor(seconds / minute);
        const remainingSeconds = seconds % minute;
        return `${minutes}min, ${remainingSeconds}s ago`;
    } else if (seconds < day) {
        const hours = Math.floor(seconds / hour);
        const remainingMinutes = Math.floor((seconds % hour) / minute);
        return `${hours}h, ${remainingMinutes}min ago`;
    } else {
        const days = Math.floor(seconds / day);
        const remainingHours = Math.floor((seconds % day) / hour);
        return `${days}d, ${remainingHours}h ago`;
    }
}

export { formatRelativeTime };