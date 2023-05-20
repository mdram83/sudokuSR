import React from "react";
import {styles} from "../../Styles/styles";
import {SvgFeatherFastForward} from "../../Svg/SvgFeatherFastForward";

export const ActionQuickNotes = (props) => {
    return (
        <div className={styles.action.div.base + styles.action.div.default} onClick={props.onClick}>
            <SvgFeatherFastForward />
        </div>
    );
}