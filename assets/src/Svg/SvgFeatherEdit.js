import React from "react";
import {styles} from "../Styles/styles";

export const SvgFeatherEdit = (props) => {

    const {'stroke-width': _, ...rest} = styles.general.svg.base;
    const properties = {'stroke-width': props.strokeWidth ?? styles.general.svg.base["stroke-width"], ...rest};

    return (
        <svg {...properties}>
            <path d="M12 20h9"></path>
            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
        </svg>
    );
}