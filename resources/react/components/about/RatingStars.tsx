import { Star } from "lucide-react";

export default function RatingStars() {
  return (
    <div className="flex items-center gap-1">
      {Array.from({ length: 5 }).map((_, index) => (
        <Star
          key={index}
          size={18}
          fill="#FFB800"
          strokeWidth={0}
          className="text-[#FFB800]"
        />
      ))}
    </div>
  );
}
