import React from "react";
import {styles} from "../../styles/styles";
import {SvgFeatherTrash} from "../../Svg/SvgFeatherTrash";

export const ActionTrash = (props) => {
    return (
        <div className={styles.action.div.base + styles.action.div.default} onClick={props.onClick}>
            <SvgFeatherTrash />
        </div>
    );
}