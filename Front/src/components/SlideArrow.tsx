import { ArrowLeft, ArrowRight } from "lucide-react";

interface SlideArrowProps {
    direction: "prev" | "next";
    onClick: () => void;
    className?: string;
}

export default function SlideArrow({ direction, onClick, className = "" }: SlideArrowProps) {
    const isPrev = direction === "prev";

    return (
        <button
            type="button"
            onClick={onClick}
            aria-label={isPrev ? "Previous slide" : "Next slide"}
            className={[
                "flex h-[38px] w-[38px] items-center justify-center",
                "rounded-[12px] border border-white/25 bg-white/30",
                "text-white backdrop-blur-md",
                "transition duration-300 hover:bg-white/45",
                className,
            ].join(" ")}
        >
            {isPrev ? <ArrowRight size={20} /> : <ArrowLeft size={20} />}
        </button>
    );
}
