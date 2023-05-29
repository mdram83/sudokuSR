import React from "react";
import {styles} from "../../styles/styles";

export const DifficultyLevelHighlightValue = (props) => {

    const className =
        styles.difficultyLevel.div.base
        + (props.active ? styles.difficultyLevel.div.active : styles.difficultyLevel.div.default);

    return (
        <div className={className} onClick={props.onClick}>
            <span className="inline-block align-middle m-0 p-0 pt-0.5 font-bold">4</span>
        </div>
    );
}