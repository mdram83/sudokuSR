import React from "react";
import {styles} from "../../Styles/styles";
import {SvgFeatherRotateCcw} from "../../Svg/SvgFeatherRotateCcw";

export const DifficultyLevelUndoAvailability = (props) => {

    const className =
        styles.difficultyLevel.div.base
        + (props.active ? styles.difficultyLevel.div.active : styles.difficultyLevel.div.default);

    return (
        <div className={className} onClick={props.onClick}>
            <SvgFeatherRotateCcw />
        </div>
    );
}