export interface ICountdownParts {
  days: number;
  hours: number;
  minutes: number;
  seconds: number;
}

export function padTime(n: number): string {
  return String(n).padStart(2, "0");
}

export function getCountdownParts(target: Date): ICountdownParts {
  const diff = Math.max(0, target.getTime() - Date.now());
  return {
    days: Math.floor(diff / (1000 * 60 * 60 * 24)),
    hours: Math.floor((diff / (1000 * 60 * 60)) % 24),
    minutes: Math.floor((diff / (1000 * 60)) % 60),
    seconds: Math.floor((diff / 1000) % 60),
  };
}
