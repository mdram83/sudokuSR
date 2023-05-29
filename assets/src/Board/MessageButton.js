import React from "react";
import {styles} from "../styles/styles";

export const MessageButton = (props) => {

    const className =
        styles.messageButton.div.base
        + (props.action != null ? styles.messageButton.div.active : styles.messageButton.div.default);

    return (
        <div className={className} onClick={props.action}>
            <span className="text-center">{props.message}</span>
        </div>
    );
}