import React from "react";
import {styles} from "../../styles/styles";
import {SvgFeatherFastForward} from "../../Svg/SvgFeatherFastForward";

export const DifficultyLevelQuickNotesAvailability = (props) => {

    const className =
        styles.difficultyLevel.div.base
        + (props.active ? styles.difficultyLevel.div.active : styles.difficultyLevel.div.default);

    return (
        <div className={className} onClick={props.onClick}>
            <SvgFeatherFastForward />
        </div>
    );
}