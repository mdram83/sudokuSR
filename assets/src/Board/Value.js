import React from "react";

export const Value = (props) => {
    return (
        <span className={
            "inline-block align-middle m-0 p-0 pt-0.5"
            + ((props.highlight && props.highlightValue) ? " font-bold" : "")
            + (props.hasInitialValue ? "" : (
                (props.valueError && props.highlightErrors) ? " text-red-700" : " text-blue-700"
            ))
        }>
            {props.value}
        </span>
    );
}