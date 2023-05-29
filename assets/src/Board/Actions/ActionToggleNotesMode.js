import React from "react";
import {styles} from "../../styles/styles";
import {SvgFeatherEdit} from "../../Svg/SvgFeatherEdit";

export const ActionToggleNotesMode = (props) => {

    const svgStrokeWidth = props.notesMode ? 2 : 1;
    const className =
        styles.action.div.base
        + (props.notesMode ? styles.action.div.active : styles.action.div.default);

    return (
        <div className={className} onClick={props.onClick}>
            <SvgFeatherEdit strokeWidth={svgStrokeWidth}/>
        </div>
    );
}