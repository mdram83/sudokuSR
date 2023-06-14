import React from "react";
import {styles} from "../styles/styles";

export const SvgFeatherCloudOff = (props) => {

    const {'width': _, 'height': __, 'fill': ___, 'className': ____, ...rest} = styles.general.svg.base;

    const properties = {
        'width': props.size ?? styles.general.svg.base.width,
        'height': props.size ?? styles.general.svg.base.height,
        'fill': props.fill ?? styles.general.svg.base.fill,
        'className': props.className ?? styles.general.svg.base.className,
        ...rest
    };

    return (
        <svg {...properties}>
            <path d="M22.61 16.95A5 5 0 0 0 18 10h-1.26a8 8 0 0 0-7.05-6M5 5a8 8 0 0 0 4 15h9a5 5 0 0 0 1.7-.3"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        </svg>
    );
}