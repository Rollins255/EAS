// import * as faceapi from 'face-api.js'
import * as faceapi from 'face-api.js'
import { useLoadingStore } from '@/stores/modelLoad'

const loadModels = async()=>{
    try{
        await faceapi.nets.faceExpressionNet.loadFromUri('/models')
        useLoadingStore().setLoading("20%")
        await faceapi.nets.faceLandmark68Net.loadFromUri('/models')
        useLoadingStore().setLoading("40%")
        await faceapi.nets.faceRecognitionNet.loadFromUri('/models')
        useLoadingStore().setLoading("60%")
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models')
        useLoadingStore().setLoading("80%")
        await faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
        useLoadingStore().setLoading("100%")
        return 1;
    }catch(err){
        console.log('error in fetching the models',err)
        return 0;
    }
}
export default loadModels;