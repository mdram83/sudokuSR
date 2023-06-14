import React from "react";
import {styles} from "../styles/styles";

export const SvgFeatherCloud = (props) => {

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
            <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
        </svg>
    );
}
