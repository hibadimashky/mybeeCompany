import { useEffect, useState } from "react";
import EditRowCompnent from "../../comp/EditRowCompnent";
import BasicInfoComponent from "../../comp/BasicInfoComponent";
import TreeTableEditorLocal from "../../comp/TreeTableEditorLocal";
import { getName } from "../../lang/Utils";
import SweetAlert2 from 'react-sweetalert2';

const WasteDetail = ({ dir, translations }) => {
    const rootElement = document.getElementById('root');
    let waste = JSON.parse(rootElement.getAttribute('waste'));
    const [currentObject, setcurrentObject] = useState(waste);
    const [showAlert, setShowAlert] = useState(false);
    
    useEffect(() => {
        //updateTotals(currentObject);
    }, [currentObject]);

    const onBasicChange = (key, value) => {
        let r = {...currentObject};
        r[key] = value;
        setcurrentObject({...r});
    }

    // const updateTotals = (row) =>{
    //     row.subtotal = row.items ? 
    //     row.items.reduce((accumulator, item) => accumulator + Number(item.total ?? 0), 0) : 0;
    //     row.total = row.subtotal + Number(row.tax ?? 0);
    //     row.grand_total = row.total + Number(row.shipping_amount ?? 0) + Number(row.misc_amount ?? 0);
    // }

    const onProductChange = (key, val) =>{
        currentObject[key] = val;
        //updateTotals(currentObject);
        setcurrentObject({...currentObject});
        return {message:"Done"};
    }

    const getErrorMessage = (data)=>{
        let res =''
        for (let index = 0; index < data.length; index++) {
            const element = data[index];
            res+=`<div>${getName(element.name_en, element.name_ar, dir)} : ${element.qty}</div>`;
        }
        return res;
    }

    const handleQuantityError = (data) => {
        setShowAlert(true);
        Swal.fire({
        show: showAlert,
        title: 'Error',
        html: `<div>${translations.notEnoughQuantity}</div>${getErrorMessage(data)}`,
        icon: "error",
        timer: 4000,
        showCancelButton: false,
        showConfirmButton: false,
        }).then(() => {
        setShowAlert(false); // Reset the state after alert is dismissed
        });
    }

    const validateObject = (data) =>{
        if(!!!data.establishment || data.establishment.length ==0) return `${translations.establishment} ${translations.required}`;
        if(!!currentObject.items && currentObject.items.filter(x=>!!!x.unit).length >0) return translations['item_unit_error'];
        return 'Success';
    }
    
    return (
        <EditRowCompnent
         defaultMenu={[
            { 
                key: 'wasteInfo', 
                visible: true, 
                comp : <BasicInfoComponent
                        currentObject={currentObject}
                        translations={translations}
                        dir={dir}
                        onBasicChange={onBasicChange}
                        fields={
                            [   
                                {key:"establishment" , title:"establishment", searchUrl:"searchEstablishments", type:"Async", required : true},
                                {key:"transaction_date" , title:"date", type:"Date", required : true, size:12},
                                {key:"description" , title:"notes", type:"TextArea", size:12, newRow: true}
                            ]
                        }
                       />
            },
            { 
                key: 'items', 
                visible: true, 
                comp : 
                <TreeTableEditorLocal
                translations={translations}
                dir={dir}
                header={false}
                addNewRow={true}
                type= {"items"}
                title={translations.items}
                currentNodes={[...currentObject.items]}
                defaultValue={{taxed : 0}}
                cols={[
                    {key : "product", autoFocus: true, searchUrl:"searchProducts", type :"AsyncDropDown", width:'30%', 
                        editable:true, required:true,
                        onChangeValue : (nodes, key, val, rowKey, postExecute) => {
                            const result = val.id.split("-");
                            axios.get(`${window.location.origin}/getProductInventory/${val.id}`)
                            .then(response => {
                                let prod = response.data;
                                nodes[rowKey].data.SKU = prod.SKU;
                                nodes[rowKey].data.item_type = result[1];
                                if(!!prod.inventory){
                                    nodes[rowKey].data.qty = prod.inventory.primary_vendor_default_quantity;
                                    nodes[rowKey].data.unit_price_before_discount = prod.inventory.primary_vendor_default_price;
                                    nodes[rowKey].data.unit = prod.inventory.unit;
                                    nodes[rowKey].data.total = !!prod.inventory.primary_vendor_default_price && !!prod.inventory.primary_vendor_default_quantity 
                                                        ? prod.inventory.primary_vendor_default_price * prod.inventory.primary_vendor_default_quantity : 0;
                                }
                                else{
                                    nodes[rowKey].data.qty = null;
                                    nodes[rowKey].data.unit_price_before_discount = null;
                                    nodes[rowKey].data.unit = null;
                                    nodes[rowKey].data.total = null;
                                }
                                postExecute(nodes);
                            })
                            .catch(error => {
                              console.error('Error fetching translations', error);
                            });
                        }
                    },
                    {key : "SKU", autoFocus: true, type :"Text", width:'15%', editable:false,
                        customCell:(data, key, currentEditing, editable)=>{
                            return <span>{!!data["product"] ? data["product"].SKU : ''}</span>
                        }
                    },
                    {key : "unit", autoFocus: true, type :"AsyncDropDown", width:'25%', editable:true, required:true,
                        searchUrl:"searchUnitTransfers",
                        relatedTo:{
                            key: "id",
                            relatedKey : "product.id"
                        }
                    },
                    {key : "qty", autoFocus: true, type :"Decimal", width:'15%', editable:true, required:true,
                        onChangeValue : (nodes, key, val, rowKey, postExecute) => {
                            // nodes[rowKey].data.total = !!val && !!nodes[rowKey].data.unit_price_before_discount ? val * nodes[rowKey].data.unit_price_before_discount : null;
                            // postExecute(nodes);
                        }
                    }
                ]}
                actions = {[]}
                onUpdate={(nodes)=> onProductChange("items", nodes)}
                onDelete={null}/>
            }
          ]}
          currentObject={currentObject}
          translations={translations}
          dir={dir}
          apiUrl={'waste'}
          afterSubmitUrl="../../waste"
          handleError={handleQuantityError}
          validateObject={validateObject}
        />
    );
}

export default WasteDetail;