import React from "react";
import {styles} from "../styles/styles";

export const SvgFeatherToggleLeft = (props) => {
    return (
        <svg {...styles.general.svg.base}>
            <rect x="1" y="5" width="22" height="14" rx="7" ry="7" fill={props.rectFill ?? 'currentColor'}></rect>
            <circle cx={props.circleCx ?? 8} cy="12" r="3" fill="#fff"></circle>
        </svg>
    );
}