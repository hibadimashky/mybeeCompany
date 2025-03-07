import React, { useState, useCallback } from 'react';
import { Button } from 'primereact/button';
import { Dropdown, Form } from 'react-bootstrap';
import ConfirmationModal from './ConfirmationModal';
import SweetAlert2 from 'react-sweetalert2';
import TreeTableEditorLocal from "../comp/TreeTableEditorLocal";
import { colors } from 'laravel-mix/src/Log';
const ProductAttribute = ({ translations, onChange, product, AttributesTree }) => {
  const rootElement = document.getElementById('root');
  let dir = rootElement.getAttribute('dir');
  const [Attributes1, setAttributes1] = useState([]);
  const [Attributes2, setAttributes2] = useState([]);
  const [AttributeClass1, setAttributeClass1] = useState(-1);
  const [AttributeClass2, setAttributeClass2] = useState(-1);
  const [editingRow, setEditingRow] = useState({});
  const [currentKey, setCurrentKey] = useState('-1');
  const [disableButton, setdisableButton] = useState(true);
  const [disableAttributeClass2, setdisableAttributeClass2] = useState(false);
  setdisableAttributeClass2
  const [showAlert, setShowAlert] = useState(false);
  const [autoObject, setAutoObject] = useState({
    'price': false,
    'SKU': false,
    'barcode': false,
    'starting': 0,
    'startingCheck': false
  });
  const [showConfirmation, setshowConfirmation] = useState(false);

  const onCloseConfirm = (event) => {
    event.preventDefault();
    setshowConfirmation(false);
  }

  const findChildrenById = (id) => {
    for (const item of AttributesTree) {
      if (item.data.id == id) {
        return item.children; // Return children if the id matches
      }
    }
    return [];
  }

  const onConfirm = (evt) => {
    evt.preventDefault();
    var newMstrix = [];
    var id = 0;
    if (AttributeClass2 != -1) {
      var Children1 = findChildrenById(AttributeClass1);
      var Children2 = findChildrenById(AttributeClass2);
      Children1.forEach(element1 => {
        Children2.forEach(element2 => {
          let newObject = {};
          if (element1.data.empty != "Y" && element2.data.empty != "Y") {
            newObject.name_ar = product.name_ar + " " + element1.data.name_ar + " " + element2.data.name_ar;
            newObject.name_en = product.name_en + " " + element1.data.name_en + " " + element2.data.name_en;
            newObject.attribute1 = {};
            newObject.attribute2 = {};
            newObject.attribute1.name_ar = element1.data.name_ar;
            newObject.attribute1.name_en = element1.data.name_en;
            newObject.attribute1Name_ar = element1.data.name_ar;
            newObject.attribute1Name_en = element1.data.name_en;
            newObject.attribute1.parent_id = AttributeClass1;
            newObject.attribute2.name_ar = element2.data.name_ar;
            newObject.attribute2.name_en = element2.data.name_en;
            newObject.attribute2Name_ar = element2.data.name_ar;
            newObject.attribute2Name_en = element2.data.name_en;
            newObject.attribute2.parent_id = AttributeClass2;
            newObject.attribute1.id = element1.data.id;
            newObject.attribute2.id = element2.data.id;
            newObject.price = autoObject.price ? product.price : 0;
            newObject.barcode = autoObject.barcode ? product.barcode : '';
            newObject.SKU = autoObject.SKU ? product.SKU : '';
            newObject.starting = autoObject.startingCheck ? autoObject.starting : 0;
            newObject.id = id + 1;
            id = id + 1;
            newMstrix.push(newObject);
          }
        });
      });
    }
    else {
      var Children1 = findChildrenById(AttributeClass1);
      Children1.forEach(element1 => {
        let newObject = {};
        if (element1.data.empty != "Y") {
          newObject.name_ar = product.name_ar + " " + element1.data.name_ar;
          newObject.name_en = product.name_en + " " + element1.data.name_en;
          newObject.attribute1 = {};
          newObject.attribute2 = {};
          newObject.attribute1.name_ar = element1.data.name_ar;
          newObject.attribute1.name_en = element1.data.name_en;
          newObject.attribute1Name_ar = element1.data.name_ar;
          newObject.attribute1Name_en = element1.data.name_en;
          newObject.attribute1.parent_id = AttributeClass1;
          newObject.attribute1.id = element1.data.id;
          newObject.price = autoObject.price ? product.price : 0;
          newObject.barcode = autoObject.barcode ? product.barcode : '';
          newObject.SKU = autoObject.SKU ? product.SKU : '';
          newObject.starting = autoObject.startingCheck ? autoObject.starting : 0;
          newObject.id = id + 1;
          id = id + 1;
          newMstrix.push(newObject);
        }
      });
    }

    onChange('attributes', newMstrix);
    setshowConfirmation(false);
  }

  const handleChange = async (key, value) => {
    if (key == "AttributeClass1") {
      setAttributeClass1(value);
      setAttributes1(findChildrenById(value));
    }
    else {
      setAttributeClass2(value);
      setAttributes2(findChildrenById(value));
    }
    if (key == "AttributeClass1" && value != -1) {
      setdisableButton(false);
      setdisableAttributeClass2(false);
    }
    else if (key == "AttributeClass1" && value == -1) {
      setdisableButton(true);
      setAttributeClass2('-1');
      setdisableAttributeClass2(true);
      setAttributes2([]);
      onGenerate([]);
    }
  }

  const handleAutoChange = (key, value) => {
    autoObject[key] = value;
    setAutoObject({ ...autoObject })
  }

  const generateNewMatrix = (evt) => {
    evt.preventDefault()
    if (AttributeClass1 != AttributeClass2) {
      setshowConfirmation(true);
    }
    else {
      setShowAlert(true);
      Swal.fire({
        show: showAlert,
        title: 'Error',
        text: translations.att1andatt2,
        icon: "error",
        timer: 2000,
        showCancelButton: false,
        showConfirmButton: false,
      }).then(() => {
        setShowAlert(false); // Reset the state after alert is dismissed
      });
    }
  }

  React.useEffect(() => {
    let productMatrix = product.attributes;
    productMatrix[0] ? !!productMatrix[0].attribute1 ? setAttributes1(findChildrenById(productMatrix[0].attribute1.parent_id)) : setAttributes1([]) : setAttributes1([]);
    productMatrix[0] ? !!productMatrix[0].attribute2 ? setAttributes2(findChildrenById(productMatrix[0].attribute2.parent_id)) : setAttributes2([]) : setAttributes2([]);
    productMatrix[0] ? (!!productMatrix[0].attribute1 ? setAttributeClass1(productMatrix[0].attribute1.parent_id) : setAttributeClass1(AttributesTree[0].data.id)) : setAttributeClass1(-1);
    productMatrix[0] ? (!!productMatrix[0].attribute2 ? setAttributeClass2(productMatrix[0].attribute2.parent_id) : setAttributeClass2(AttributesTree[1].data.id)) : setAttributeClass2(-1);
  }, []);

  const handleDelete = (row) =>{
    let index = product.attributes.findIndex(x=>x.id == row.id);
    if (product.attributes[index]['deleted'] == 1)
      product.attributes[index]['deleted'] = 0;
    else
      product.attributes[index]['deleted'] = 1;
    onChange("attributes", product.attributes);
    return { message : 'Done'};
}

// const handleActiveDeactiveMatrix = (id) => {
  //   var editedMatrix = [...productMatrix];
  //   var index = 0;
  //   for (let i = 0; i < editedMatrix.length; i++) {
  //     if (editedMatrix[i].id == id) {
  //       break;
  //     }
  //     index = index + 1;
  //   }
  //   if (editedMatrix[index]['deleted'] == 1)
  //     editedMatrix[index]['deleted'] = 0;
  //   else
  //     editedMatrix[index]['deleted'] = 1;

  //   setProductMatrix([...editedMatrix]);
  // }

  return (
    <>
      <SweetAlert2 />
      <ConfirmationModal
        visible={showConfirmation}
        onClose={onCloseConfirm}
        onConfirm={onConfirm}
        message={translations.MatrixConfirmation}
        translations={translations}
      >
      </ConfirmationModal>

      <div class="card-body" dir={dir}>
        <form>
          <div class="form-group">
            <div class="row">
              <div class="col-6">
                <label for="attributeSet" class="col-form-label">{translations.attr_set1}</label>
                <select class="form-control selectpicker" value={AttributeClass1} onChange={(e) => handleChange('AttributeClass1', e.target.value)} >
                  <option key='-1' value='-1'>
                    {translations.nodata}
                  </option>
                  {AttributesTree.map((option) => (
                    (option.data.id) ?
                      <option key={option.key} value={option.data.id}>
                        {dir == "rtl" ? option.data.name_ar : option.data.name_en}
                      </option>
                      : <></>
                  ))}
                </select>
              </div>
              <div class="col-6">
                <label for="AttrebuteSet" class="col-form-label">{translations.attr_set2_value}</label>
                <div class='parent'>
                  {Attributes1.map((option) => (
                    <p class='child'> {dir == "rtl" ? option.data.name_ar : option.data.name_en}</p>
                  ))
                  }
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <label for="attributeSet" class="col-form-label">{translations.attr_set2}</label>
                <select class="form-control selectpicker" disabled={disableAttributeClass2} value={AttributeClass2} onChange={(e) => handleChange('AttributeClass2', e.target.value)} >
                  <option key='-1' value='-1'>
                    {translations.nodata}
                  </option>
                  {AttributesTree.map((option) => (
                    (option.data.id) ?
                      <option key={option.key} value={option.data.id}>
                        {dir == "rtl" ? option.data.name_ar : option.data.name_en}
                      </option> :
                      <></>
                  ))}
                </select>
              </div>
              <div class="col-6">
                <label for="AttrebuteSet" class="col-form-label">{translations.attr_set2_value}</label>
                <div class='parent'>
                  {Attributes2.map((option) => (
                    <p class='child'> {dir == "rtl" ? option.data.name_ar : option.data.name_en}</p>
                  ))
                  }
                </div>
              </div>
            </div>
          </div>
        </form>
        <div>
          <div class="row" style={{ padding: "5px" }}>
            <div class="col-6"></div>
            <div class="col-6">
              <div class="row">
                <div class="col-8">
                  <Button className="GenaerateButton btn btn-primary"
                    variant="primary"
                    disabled={disableButton} onClick={(e) => generateNewMatrix(e)}>
                    {translations.generateMatrix}
                  </Button>
                </div>
                <div class="col-4">
                  <Dropdown>
                    <Dropdown.Toggle disabled={disableButton} className="GenaerateButton" variant="sec" id="dropdown-basic">
                      {translations.autofill}
                    </Dropdown.Toggle>
                    <Dropdown.Menu style={{ padding: '10px' }}>
                      <Form.Group className="mb-3" controlId="formBasicCheckbox">
                        <Form.Check type="checkbox" label={translations.price}
                          checked={!!autoObject.price ? autoObject.price : false}
                          onChange={(e) => handleAutoChange('price', e.target.checked)} />
                      </Form.Group>
                      <Dropdown.Divider />
                      <Form.Group className="mb-3" controlId="formBasicCheckbox">
                        <Form.Check type="checkbox" label={translations.barcode}
                          checked={!!autoObject.barcode ? autoObject.barcode : false}
                          onChange={(e) => handleAutoChange('barcode', e.target.checked)} />
                      </Form.Group>
                      <Dropdown.Divider />
                      <Form.Group className="mb-3" controlId="formBasicCheckbox">
                        <Form.Check type="checkbox" label={translations.SKU}
                          checked={!!autoObject.SKU ? autoObject.SKU : false}
                          onChange={(e) => handleAutoChange('SKU', e.target.checked)} />
                      </Form.Group>
                      <Dropdown.Divider />
                      <Form.Group className="mb-3" controlId="formBasicCheckbox">
                        <Form.Check type="checkbox" label={translations.inventory}
                          checked={!!autoObject.startingCheck ? autoObject.startingCheck : false}
                          onChange={(e) => handleAutoChange('startingCheck', e.target.checked)} />
                        <Form.Control type="number" min="0"
                          value={autoObject.starting}
                          onChange={(e) => handleAutoChange('starting', e.target.value)} />
                      </Form.Group>
                    </Dropdown.Menu>
                  </Dropdown>
                </div>
              </div>
            </div>
          </div>
          <TreeTableEditorLocal
            translations={translations}
            dir={dir}
            header={false}
            addNewRow={false}
            type={"attribute"}
            title={translations.recipe}
            currentNodes={product.attributes}
            defaultValue={{}}
            cols={[
              {
                key: dir == "rtl" ? "attribute1Name_ar" : "attribute1Name_en",
                title: "attr_value1", autoFocus: false, type: "Text", width: '10%',
                editable: false,
                customCell : (data, key) => {
                  return (
                    <span style={data.deleted == 1? {color:"#DCDCDC"}: {color:"black"}}>{data[key]}</span>
                  )
                }
              },
              {
                key: dir == "rtl" ? "attribute2Name_ar" : "attribute2Name_en",
                title: "attr_value2", autoFocus: false, type: "Text", width: '10%',
                editable: false,
                customCell : (data, key) => {
                  return (
                    <span style={data.deleted == 1? {color:"#DCDCDC"}: {color:"black"}}>{data[key]}</span>
                  )
                }
              },
              { key: "name_ar", autoFocus: true, type: "Text", width: '15%', editable: true, required: true },
              { key: "name_en", autoFocus: true, type: "Text", width: '15%', editable: true, required: true },
              { key: "price", autoFocus: true, type: "Decimal", width: '15%', editable: true, required: true },
              { key: "barcode", autoFocus: true, type: "Text", width: '15%', editable: true, required: false },
              { key: "SKU", autoFocus: true, type: "Text", width: '10%', editable: true, required: false },
            ]}
            actions = {[
              {
                execute: (data)=>handleDelete(data),
                customRender : (data) => data.deleted == 1 ? <i class={`ki-outline ki-plus fs-2`}/> : <i class={`ki-outline ki-trash fs-2`}/>}
              ]}
            onUpdate={(nodes) => onChange('attributes', nodes)}
            onDelete={null} />
        </div>
      </div>
    </>

  );
};


export default ProductAttribute;
