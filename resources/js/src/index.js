import React, { Suspense } from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';

import { I18nextProvider } from 'react-i18next';
import i18n from './Translate/i18n';

import store from './redux/store';
import { Provider } from 'react-redux';

import Loader from './components/Loader';

//const AppTranslated = withTranslation()(App);

ReactDOM.render(
  <Provider store={store} >
    <Suspense fallback={<Loader />}>
      <I18nextProvider i18n={i18n}>
        <App />
      </I18nextProvider>
    </Suspense>
  </Provider>,
  document.getElementById('root')
);
