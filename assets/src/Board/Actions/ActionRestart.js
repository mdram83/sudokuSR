import React from "react";
import {styles} from "../../Styles/styles";
import {SvgFeatherRefreshCcw} from "../../Svg/SvgFeatherRefreshCcw";

export const ActionRestart = (props) => {
    return (
        <div className={styles.action.div.base + styles.action.div.default} onClick={props.onClick}>
            <SvgFeatherRefreshCcw />
        </div>
    );
}