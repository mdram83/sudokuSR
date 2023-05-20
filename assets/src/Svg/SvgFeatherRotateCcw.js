import React from "react";
import {styles} from "../Styles/styles";

export const SvgFeatherRotateCcw = () => {
    return (
        <svg {...styles.general.svg.base}>
            <polyline points="1 4 1 10 7 10"></polyline>
            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
        </svg>
    );
}