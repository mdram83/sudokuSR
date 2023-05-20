import React from "react";
import {styles} from "../Styles/styles";

export const SvgFeatherPlay = (props) => {

    const {'width': _, 'height': __, 'fill': ___, 'className': ____, ...rest} = styles.general.svg.base;

    const properties = {
        'width': props.size ?? styles.general.svg.base.width,
        'height': props.size ?? styles.general.svg.base.height,
        'fill': props.fill ?? styles.general.svg.base.fill,
        ...rest
    };

    return (
        <svg {...properties}>
            <polygon points="5 3 19 12 5 21 5 3"></polygon>
        </svg>
    );
}