import React from "react";
import ReactDOM from "react-dom";
import '@fortawesome/fontawesome-free/css/all.min.css';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

import UserTable from "./components/backend/user/UserTable";
import UserForm from "./components/backend/user/UserForm"; 


import CodeTable from "./components/backend/code/CodeTable";
import CodeForm from "./components/backend/code/CodeForm"; 

import LanguageTable from "./components/backend/language/LanguageTable";
import LanguageForm from "./components/backend/language/LanguageForm"; 

import FloorTable from "./components/backend/floor/FloorTable";
import FloorForm from "./components/backend/floor/FloorForm"; 

import ElementTable from "./components/backend/element/ElementTable";
import ElementForm from "./components/backend/element/ElementForm"; 

import ImageMapWithPointers from "./components/backend/common/ImageWithPointers";

import PageTable from "./components/backend/page/PageTable";
import PageForm from "./components/backend/page/PageForm";


//User
if (document.getElementById("user-table")) {
    ReactDOM.render(<UserTable />, document.getElementById("user-table"));
}
if (document.getElementById("user-form")) {
    const userElement = document.getElementById("user-form");
    const userData = userElement.getAttribute('data-user'); // Obtiene el valor de data-user
    const user = userData ? JSON.parse(userData) : null; // Parsear si hay datos

    ReactDOM.render(<UserForm user={user} />, userElement);
}


//Code
if (document.getElementById("code-table")) {
    ReactDOM.render(<CodeTable />, document.getElementById("code-table"));
}
if (document.getElementById("code-form")) {
    const codeElement = document.getElementById("code-form");
    const codeData = codeElement.getAttribute('data-code'); // Obtiene el valor de data-code
    const code = codeData ? JSON.parse(codeData) : null; // Parsear si hay datos

    ReactDOM.render(<CodeForm code={code} />, codeElement);
}

//Language
if (document.getElementById("language-table")) {
    ReactDOM.render(<LanguageTable />, document.getElementById("language-table"));
}
if (document.getElementById("language-form")) {
    const languageElement = document.getElementById("language-form");
    const languageData = languageElement.getAttribute('data-language'); // Obtiene el valor de data-language
    const language = languageData ? JSON.parse(languageData) : null; // Parsear si hay datos

    ReactDOM.render(<LanguageForm language={language} />, languageElement);
}


//Floor
if (document.getElementById("floor-table")) {
    ReactDOM.render(<FloorTable />, document.getElementById("floor-table"));
}
if (document.getElementById("floor-form")) {
    const floorElement = document.getElementById("floor-form");
    const floorData = floorElement.getAttribute('data-floor'); // Obtiene el valor de data-floor
    const floor = floorData ? JSON.parse(floorData) : null; // Parsear si hay datos

    // Obtiene los datos de fields
    const fieldsData = floorElement.getAttribute('data-fields');
    const fields = fieldsData ? JSON.parse(fieldsData) : null; // Parsear si hay datos

    ReactDOM.render(
        <FloorForm floor={floor} fields={fields} />,
        floorElement
    );
}


//Element
if (document.getElementById("element-table")) {
    const elementDatableElement = document.getElementById("element-table");
    const floorData = elementDatableElement.getAttribute('data-floor'); // Obtiene el valor de data-floor
    const floor = floorData ? JSON.parse(floorData) : null; // Parsear si hay datos


    ReactDOM.render(<ElementTable  floor={floor} />, elementDatableElement);
}
if (document.getElementById("element-form")) {
    const elementElement = document.getElementById("element-form");
    const elementData = elementElement.getAttribute('data-element'); // Obtiene el valor de data-element
    const element = elementData ? JSON.parse(elementData) : null; // Parsear si hay datos

    const floorData = elementElement.getAttribute('data-floor'); // Obtiene el valor de data-floor
    const floor = floorData ? JSON.parse(floorData) : null; // Parsear si hay datos

    // Obtiene los datos de fields
    const fieldsData = elementElement.getAttribute('data-fields');
    const fields = fieldsData ? JSON.parse(fieldsData) : null; // Parsear si hay datos

    ReactDOM.render(
        <ElementForm element={element} floor={floor} fields={fields} />,
        elementElement
    );
}


//Image With Pointers
if (document.getElementById("image-with-pointers")) {

    const imageWithPointersElement = document.getElementById("image-with-pointers");

    const floorData = imageWithPointersElement.getAttribute('data-floor'); // Obtiene el valor de data-floor
    const floor = floorData ? JSON.parse(floorData) : null; // Parsear si hay datos

    const pointersData = imageWithPointersElement.getAttribute('data-pointers'); // Obtiene el valor de data-floor
    const pointers = floorData ? JSON.parse(pointersData) : null; // Parsear si hay datos

    ReactDOM.render(
        <ImageMapWithPointers
                    image={"/storage/medias/original/"+floor.map}
                    pointers={pointers}
                    edit={false}
                    onChange={null}
                />, 
        imageWithPointersElement
    );


}


if (document.getElementById("page-table")) {
    ReactDOM.render(<PageTable />, document.getElementById("page-table"));
}

if (document.getElementById("page-form")) {
    const pageElement = document.getElementById("page-form");
    const pageData = pageElement.getAttribute('data-page'); // Obtiene el valor de data-element
    const page = pageData ? JSON.parse(pageData) : null; // Parsear si hay datos

    // Obtiene los datos de fields
    const fieldsData = pageElement.getAttribute('data-fields');
    const fields = fieldsData ? JSON.parse(fieldsData) : null; // Parsear si hay datos

    ReactDOM.render(
        <PageForm page={page} fields={fields} />,
        pageElement
    );
}