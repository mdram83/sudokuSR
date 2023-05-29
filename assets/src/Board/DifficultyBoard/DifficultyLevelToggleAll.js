import React from "react";
import {styles} from "../../styles/styles";
import {SvgFeatherToggleLeft} from "../../Svg/SvgFeatherToggleLeft";

export const DifficultyLevelToggleAll = (props) => {

    let active = null;
    let rectFill = "#6ee7b7";
    let circleCx = "8";

    const levels = props.difficultyLevel;

    if (Object.values(levels).every(level => level === true)) {
        active = true;
        rectFill = "#6ee7b7";
        circleCx = "16";
    } else if (Object.values(levels).every(level => level === false)) {
        active = false;
        rectFill = "#e5e7eb";
    }

    const className =
        styles.difficultyLevel.div.base
        + (active ? styles.difficultyLevel.div.active : styles.difficultyLevel.div.default);

    return (
        <div className={className} onClick={() => props.toggleAll()}>
            <SvgFeatherToggleLeft circleCx={circleCx} rectFill={rectFill} />
        </div>
    );
}