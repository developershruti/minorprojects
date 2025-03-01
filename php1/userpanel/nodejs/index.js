var express=require('express'); 
var bodyParser = require('body-parser'); 
const BigNumber = require('bignumber.js'); 
var app=express(); 
app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json()); 
const Web3 = require('web3'); 
const contractJson = require('./contract.json'); 

///Testnet
// const checkUrl     = "https://data-seed-prebsc-1-s1.binance.org:8545/";
// const adminPrivKey = ''; 
///Mainnet

const checkUrl     = "https://bsc-dataseed.binance.org/";  
const adminPrivKey = ''; 

// const web3Bsc      = new Web3(checkUrl);
// const { address: admin } = web3Bsc.eth.accounts.wallet.add(adminPrivKey); 
// const contractObj  = new web3Bsc.eth.Contract(
//   contractJson.abi,
//   contractJson.contractAddress 
// );  
// app.post('/withdrawal',async function(req,res) { /**/
// 		var tokenAddress  = req.body.tokenAddress;
// 		console.log(walletAddress);
// 		console.log(tokenAddress);
// 		console.log(amount);
// 		var walletAddress = req.body.wallet_address;
// 		var amount = req.body.amount;
// 	 	amount = amount.toString(16);
// 		amount = "0x"+amount;
// 		var tx = contractObj.methods.withdrawalToAddress(walletAddress,tokenAddress,amount);
// 		const [gasPrice, gasCost] = await Promise.all([
// 				web3Bsc.eth.getGasPrice(),
// 				tx.estimateGas({from: admin}),
// 			  ]);			  
// 		const data = tx.encodeABI();
// 			  const txData = {
// 				from: admin,
// 				to: contractObj.options.address,
// 				data,
// 				gas: gasCost,
// 				gasPrice
// 			  };
// 		//const receipt = await web3Bsc.eth.sendTransaction(txData)
// 			web3Bsc.eth.sendTransaction(txData)
// 				.on('transactionHash', function(hash){
					
// 				})
// 				.on('receipt', function(receipt){
// 				})
// 				.on('confirmation', function(confirmationNumber, receipt){ 
// 					return res.send({success:true,message:"Data updated",data:receipt.transactionHash});
// 				})
// 				.on('error', function(error){
// 					return res.send({success:false,message:"Something Went Wrong",data:error});
// 				});				  
// 		//return res.send({success:true,message:"Data updated",data:receipt.transactionHash});
		
	
// });
app.get("/tx_details",async function(req,res){
	var getTxId = req.query.tx_id;
	var httpWeb3 = new Web3(new Web3.providers.HttpProvider(checkUrl));
	var txEthResp = await httpWeb3.eth.getTransactionReceipt(getTxId);
	return res.send({success:true,message:"tx detail",data:txEthResp});
});
app.get("/",async function(req,res){
 	return res.send({success:true, message:"tx wotking "  });
});
var server=app.listen(3300,function(){
	console.log("server started at port 3300");	
}); 