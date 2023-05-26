import React from 'react';
import ReactDOM from 'react-dom/client';
import {GameInitiation} from "./Game/GameInitiation";

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <GameInitiation />
  </React.StrictMode>
);
