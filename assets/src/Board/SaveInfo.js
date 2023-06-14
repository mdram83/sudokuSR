import React from "react";
import {styles} from "../styles/styles";
import {SvgFeatherCloud} from "../Svg/SvgFeatherCloud";
import {SvgFeatherCloudOff} from "../Svg/SvgFeatherCloudOff";

export const SaveInfo = (props) => {

    let customStyles = styles.saveInfo.default;
    let saveMessage = 'auto-saving on';
    let saveIcon = <SvgFeatherCloud width={20} height={20} className='mt-0 mr-2' />;

    if (props.saveWarning) {
        customStyles = styles.saveInfo.warning;
        saveMessage = 'saving...';
    }

    if (props.saveError) {
        customStyles = styles.saveInfo.error;
        saveMessage = 'saving disabled';
        saveIcon = <SvgFeatherCloudOff width={20} height={20} className='mt-0 mr-2' />
    }

    return (
        <div className={styles.saveInfo.base + customStyles}>
            {saveIcon}
            {saveMessage}
        </div>
    );
}