/**
 * @description Get current minute and hour in 12 hour format
 * @returns string )example: 12:00)
 */
export function getToLocaleTimeString(): string {
    return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}