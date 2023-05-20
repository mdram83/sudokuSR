import React from "react";
import {styles} from "../Styles/styles";

export const SvgFeatherPause = (props) => {

    const {'width': _, 'height': __, 'fill': ___, 'className': ____, ...rest} = styles.general.svg.base;

    const properties = {
        'width': props.size ?? styles.general.svg.base.width,
        'height': props.size ?? styles.general.svg.base.height,
        'fill': props.fill ?? styles.general.svg.base.fill,
        ...rest
    };

    return (
        <svg {...properties}>
            <rect x="6" y="4" width="4" height="16"></rect>
            <rect x="14" y="4" width="4" height="16"></rect>
        </svg>
    );
}