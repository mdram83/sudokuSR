import React from "react";
import {SvgFeatherPause} from "../Svg/SvgFeatherPause";
import {SvgFeatherPlay} from "../Svg/SvgFeatherPlay";
import {MessageButton} from "./MessageButton";

export const Timer = (props) => {
    return (
        <div className="grid grid-cols-1 gap-1 w-72 mt-0 mb-0.5">
            <div className="flex justify-end text-sm">

                <div className="mr-2 pt-0.5 text-blue-700 hover:cursor-pointer" onClick={props.toggleTimer}>
                    {props.timer.on
                        ? <SvgFeatherPause size={16} fill="currentColor"/>
                        : <SvgFeatherPlay size={16} fill="currentColor" />
                    }
                </div>

                <div className="text-gray-500">
                    {new Date(props.timer.duration * 1000).toISOString().substring(11, 19)}
                </div>
            </div>

            {!props.timer.on && <MessageButton action={props.toggleTimer} message="Game paused. Click to resume..." />}

        </div>
    );
}