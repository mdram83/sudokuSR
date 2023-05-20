import React from "react";
import {styles} from "../../Styles/styles";
import {SvgFeatherRotateCcw} from "../../Svg/SvgFeatherRotateCcw";

export const ActionUndo = (props) => {
    return (
        <div className={styles.action.div.base + styles.action.div.default} onClick={props.onClick}>
            <SvgFeatherRotateCcw />
        </div>
    );
}