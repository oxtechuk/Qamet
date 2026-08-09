import type { IContactBranch } from "../types/contact.types";

export interface IBranchMapCardProps {
    branches: IContactBranch[];
    activeBranchIdx: number;
    onBranchChange: (idx: number) => void;
}
