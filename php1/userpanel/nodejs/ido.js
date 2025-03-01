const token_address = "0xdb9c8d2daed1cdda5c34274c0a4d46dc826c65cd";
const token_abi = [
  {
    "anonymous": false,
    "inputs": [
      {
        "indexed": true,
        "internalType": "address",
        "name": "previousOwner",
        "type": "address"
      },
      {
        "indexed": true,
        "internalType": "address",
        "name": "newOwner",
        "type": "address"
      }
    ],
    "name": "OwnershipTransferred",
    "type": "event"
  },
  {
    "inputs": [],
    "name": "renounceOwnership",
    "outputs": [],
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "inputs": [
      {
        "internalType": "address payable",
        "name": "addr_",
        "type": "address"
      }
    ],
    "name": "setWalletAddress",
    "outputs": [],
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "transfer",
    "outputs": [],
    "stateMutability": "payable",
    "type": "function"
  },
  {
    "inputs": [
      {
        "internalType": "address",
        "name": "newOwner",
        "type": "address"
      }
    ],
    "name": "transferOwnership",
    "outputs": [],
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "owner",
    "outputs": [
      {
        "internalType": "address",
        "name": "",
        "type": "address"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  },
  {
    "inputs": [],
    "name": "walletAddress",
    "outputs": [
      {
        "internalType": "address payable",
        "name": "",
        "type": "address"
      }
    ],
    "stateMutability": "view",
    "type": "function"
  }
]
///const receive_add = "";


const chainIdMsg = "Please select Polygon Network";

var provider;
var web3;
var userAddr;
var connectedWallet = "";

const startup = async function () {
  if (localStorage.getItem("connectedwallet") === "metamask") {
    if (window.ethereum) {
      if (window.ethereum.isMetaMask) {
        // Validate chainId is 56
        var chainId = await ethereum.request({ method: "eth_chainId" });
        console.log(chainId);
        if (chainId != 137) {
          alert("Kindly Switch to matic network.");
          return;
        }
        if (window.ethereum.selectedAddress) {
          provider = window.web3.currentProvider;
          web3 = new Web3(provider);
          userAddr = await window.ethereum.selectedAddress;
          connectedWallet = "metamask";
          document.getElementById("connect").textContent = "Disconnect";
          //document.getElementById("connectm").textContent = "Disconnect";
          //window.location = 'login_func.php?userAddr='+userAddr;
        }
      }
    }
  } else if (localStorage.getItem("connectedwallet") === "trustwallet") {
    // Get an instance of the WalletConnect connector
    provider = new window.WalletConnectProvider.default({
      rpc: {
        137: "https://polygon-rpc.com",
      },
      bridge: "https://bridge.walletconnect.org",
      chainId: 137,
      qrcode: false,
    });
    await provider.enable();
    web3 = new window.Web3(provider);
    userAddr = provider.accounts[0];
    connectedWallet = "trustwallet";
    document.getElementById("connect").textContent = "Disconnect";
    //document.getElementById("connectm").textContent = "Disconnect";
    console.log(userAddr);
    // window.location = 'login_func.php?userAddr='+userAddr;
  }
};

const connectWallet = async function () {
  var buttonText = document.getElementById("connect").textContent;
  if (buttonText === "Connect Wallet") {
    //$("#myModal").modal("show");
   // window.location = 'connect.php';
    return;
  }
  if (buttonText === "Disconnect") {
    await disconnectWallet();
    buttonText = "Connect Wallet";
    localStorage.removeItem("connectedwallet");
    window.location = 'logout.php';
  }
};

const disconnectWallet = async function () {
  if (localStorage.getItem("connectedwallet") === "trustwallet") {
    // Close provider session
    await provider.disconnect();
  }
  // provider = null;
  // web3 = null;
  // userAddr = null;
  // connectedWallet = "";

  document.getElementById("connect").textContent = "Connect Wallet";
  document.getElementById("connectm").textContent = "Connect Wallet";
  location.reload();

};

const initializeMetamask = async function () {
  if (window.ethereum) {
    if (window.ethereum.isMetaMask) {
      provider = window.web3.currentProvider;
      web3 = new Web3(provider);
      // web3.eth.getChainId().then(console.log);


      if (window.ethereum.selectedAddress) {
        userAddr = await window.ethereum.selectedAddress;
        connectedWallet = "metamask";
        //document.getElementById("connect").textContent = "Disconnect";
        //document.getElementById("connectm").textContent = "Disconnect";
        localStorage.setItem("connectedwallet", "metamask");
       // window.location = 'login_func.php?userAddr=' + userAddr;

        //  $("#myModal").modal("hide");
        return;
      }
      try {
        // Request account access if needed
        await window.ethereum.enable();
      } catch (error) {
        console.log("User denied account access.");
      }
      const accounts = await window.ethereum.request({
        method: "eth_requestAccounts",
      });
      userAddr = accounts[0];
      connectedWallet = "metamask";
      // alert(userAddr);
     // document.getElementById("connect").textContent = "Disconnect";
     // document.getElementById("connectm").textContent = "Disconnect";
      localStorage.setItem("connectedwallet", "metamask");
      //window.location = 'login_func.php?userAddr=' + userAddr;
      //$("#myModal").modal("hide");
    }
  }
};

const initializeTrustWallet = async function () {
  // Get an instance of the WalletConnect connector
  provider = new window.WalletConnectProvider.default({
    rpc: {
      137: "https://polygon-rpc.com",
    },
    bridge: "https://bridge.walletconnect.org",
    chainId: 137,
    qrcode: true,
  });
  await provider.enable();

  web3 = new window.Web3(provider);
  userAddr = provider.accounts[0];
  connectedWallet = "trustwallet";
  //document.getElementById("connect").textContent = "Disconnect";
  //document.getElementById("connectm").textContent = "Disconnect";
  localStorage.setItem("connectedwallet", "trustwallet");
  //window.location = 'login_func.php?userAddr=' + userAddr;
  //$("#myModal").modal("hide");
};

const checkAllowance = async () => {
  $("#walletAddress").html(userAddr);
  var Token = new web3.eth.Contract(token_abi, token_address);
  await Token.methods
    .allowance(userAddr, buy_addr)
    .call({ from: userAddr }, function (err, result) {
      if (result == 0) {
        $(".busdBuy").removeAttr("onclick");
        $(".busdBuy").attr("onclick", "approve()");
        $(".busdBuy").html("Approve Wallet");
      }
    });
};

const approve = async () => {
  $(".busdBuy").removeAttr("onclick");
  var Token = new web3.eth.Contract(token_abi, token_address);
  var amt = 350000000000000000000000000;
  var amount = "0x" + amt.toString(16);
  await Token.methods
    .approve(buy_addr, amount)
    .send({ from: userAddr }, function (err, result) {
      if (err !== null) {
        $.toast({
          heading: "Approve Alert",
          text: "Approve request reject by user",
          icon: "error",
          hideAfter: 15000,
          showHideTransition: "slide", // It can be plain, fade or slide
        });
        $(".approve").attr("onclick", "approve()");
      } else {
        $.toast({
          heading: "Approve Alert",
          text: "Processing... Please wait <img src='../img/ajaxloader.gif' />",
          icon: "success",
          hideAfter: 15000,
          showHideTransition: "slide", // It can be plain, fade or slide
        });

        setTimeout(function () {
          location.reload();
        }, 20000);
      }
    });
};

const register_now = async () => {

  if (!localStorage.getItem("connectedwallet")){
    alert("Kindly connect your wallet");
    return;
  }

  var inputAmt = $("#buy_amount").val();
  document.getElementById("Submit").textContent = "Please Wait...";
  //console.log(userAddr);

  /* 
  if (inputAmt <= 0) {
    $.toast({ heading: "Error", text: "Invalid Amount", icon: "error" });
    return false;
  }
   */
  var Token_contract = new web3.eth.Contract(token_abi, token_address);
  const amount = web3.utils.toWei(inputAmt.toString(), "ether");
  //const maxFeePerGas = web3.utils.toWei(40000000000.toString(), "ether");

  const result = await Token_contract.methods
    .transfer()
    .estimateGas({ from: userAddr, value: amount })
    .then((gasLimit) => {
      console.log(gasLimit);
      Token_contract.methods
        .transfer()
        .send({ from: userAddr, value: amount,gasLimit:gasLimit,
          maxFeePerGas:"250000000000",
          maxPriorityFeePerGas:"50000000000",
      }).then((function(receipt){ 
        if (!receipt.status) {
          $.toast({
            heading: "Error",
            text: "Transaction reject by user",
            icon: "error",
          });
        } else {
  
          $("#creq_txnhash").val(receipt.transactionHash);
          $("#creq_status").val(receipt.status);
          $("#creq_useraddr").val(userAddr);
          $("form#depositform").submit();
          // $.toast({heading: 'Success',text: "View On  <a target='_blank' href='https://testnet.bscscan.com/tx/"+result+"'> BlockChain </a>" ,icon: 'success',hideAfter: 15000});
        }
       }))

    })
    
  };


  const upgrade_now = async () => {

    if (!localStorage.getItem("connectedwallet")){
      alert("Kindly connect your wallet");
      return;
    }
    
    var inputAmt = $("#buy_amount").val();
    
    if (inputAmt <= 0) {
      $.toast({ heading: "Error", text: "Invalid Amount", icon: "error" });
      return false;
    }
    document.getElementById("Submit").textContent = "Please Wait...";
    var Token_contract = new web3.eth.Contract(token_abi, token_address);
    const amount = web3.utils.toWei(inputAmt.toString(), "ether");
    //const maxFeePerGas = web3.utils.toWei(40000000000.toString(), "ether");
  
    const result = await Token_contract.methods
      .transfer()
      .estimateGas({ from: userAddr, value: amount })
      .then((gasLimit) => {
        console.log(gasLimit);
        Token_contract.methods
          .transfer()
          .send({ from: userAddr, value: amount, gasLimit:gasLimit,
            maxFeePerGas:"250000000000",
            maxPriorityFeePerGas:"50000000000",
        }).then((function(receipt){ 
          if (!receipt.status) {
            $.toast({
              heading: "Error",
              text: "Transaction reject by user",
              icon: "error",
            });
          } else {
    
            $("#creq_txnhash").val(receipt.transactionHash);
            $("#creq_status").val(receipt.status);
            $("#creq_useraddr").val(userAddr);
            $("form#depositform").submit();
            // $.toast({heading: 'Success',text: "View On  <a target='_blank' href='https://testnet.bscscan.com/tx/"+result+"'> BlockChain </a>" ,icon: 'success',hideAfter: 15000});
          }
         }))
  
      })
      
    };
  
const upgrade_now_old = async () => {
  var inputAmt = $("#buy_amount").val();
  var Token_contract = new web3.eth.Contract(token_abi, token_address);
  const amount = web3.utils.toWei(inputAmt.toString(), "ether");

  const result = await Token_contract.methods
    .transfer()
    .send({ from: userAddr, value: amount });

  if (!result.status) {
    $.toast({
      heading: "Error",
      text: "Transaction reject by user",
      icon: "error",
    });
  } else {

    $("#creq_txnhash").val(result.transactionHash);
    $("#creq_status").val(result.status);
    $("#creq_useraddr").val(userAddr);
    $("form#depositform").submit();
    // $.toast({heading: 'Success',text: "View On  <a target='_blank' href='https://testnet.bscscan.com/tx/"+result+"'> BlockChain </a>" ,icon: 'success',hideAfter: 15000});
  }

};


const deposit = async () => {
  var inputAmt = $("#buy_amount").val();
  var cuRate = $("#form_current_price").val();
  if (inputAmt <= 0) {
    $.toast({ heading: "Error", text: "Invalid Amount", icon: "error" });
    return false;
  }

  //var weiAmt      = 1000000000000000000*inputAmt;
  //var hexaDecimal =  "0x"+weiAmt.toString(16);
  var Token_contract = new web3.eth.Contract(token_abi, token_address);
  var inputAmtToken = parseInt(inputAmt / cuRate);
  const amount = web3.utils.toWei(inputAmtToken.toString(), "ether");

  console.log(inputAmtToken);

  Token_contract.methods
    .transfer(receive_add, amount)
    .send({ from: userAddr }, function (err, result) {
      if (err !== null) {
        $.toast({
          heading: "Error",
          text: "Transaction reject by user",
          icon: "error",
        });
      } else {
        $("#creq_txnhash").val(result);
        $("form#depositform").submit();
        // $.toast({heading: 'Success',text: "View On  <a target='_blank' href='https://testnet.bscscan.com/tx/"+result+"'> BlockChain </a>" ,icon: 'success',hideAfter: 15000});
      }
    });
};

const buy_package = async () => {

  if (!localStorage.getItem("connectedwallet")) {
    alert("Kindly connect your wallet");
    return;
  }

  var inputAmt = $("#topup_amount").val();
  var cuRate = $("#form_current_price").val();
  var walletAmt = $("#rw_amount").val();
  var inputCoin = $("#buy_coin").val();
  var bnbValue = $("#buy_coin_value").val();

  //var cuRate  = $("#form_current_price").val();
  if (inputAmt <= 0) {
    $.toast({ heading: "Error", text: "Invalid Amount", icon: "error" });
    return false;
  }

  //var weiAmt      = 1000000000000000000*inputAmt;
  //var hexaDecimal =  "0x"+weiAmt.toString(16);
  var Token_contract = new web3.eth.Contract(token_abi, token_address);
  var bridge_contract = new web3.eth.Contract(buy_abi, buy_addr);
  var busd_contract = new web3.eth.Contract(busd_abi, busd_addr);

  var inputAmt2 = inputAmt - walletAmt;
  var bnbAmount = web3.utils.toWei(
    (inputAmt2 / bnbValue).toFixed(17).toString(),
    "ether"
  );
  var inputAmtToken = inputAmt2 / cuRate;
  //alert(cuRate);
  const amount = web3.utils.toWei(
    inputAmtToken.toFixed(17).toString(),
    "ether"
  );
  const busd_amount = web3.utils.toWei(
    inputAmt2.toFixed(17).toString(),
    "ether"
  );
  const busd_aprove_amount = web3.utils.toWei(
    (inputAmt2 * 1000).toFixed(17).toString(),
    "ether"
  );
  //console.log(bnbAmount);

  if (inputCoin == 0) {
    const result1 = await busd_contract.methods
      .approve(buy_addr, busd_aprove_amount)
      .send({ from: userAddr });
    if (!result1) {
      $.toast({
        heading: "Error",
        text: "approve not successfull",
        icon: "error",
      });
      return;
    }
    console.log(busd_amount);
    const result2 = await bridge_contract.methods
      .swapTokens(busd_amount, 0)
      .send({ from: userAddr });
    //console.log(result2);
    if (!result2) {
      $.toast({
        heading: "Error",
        text: "Transaction reject by user",
        icon: "error",
      });
      ///console.log('testtest');
      return;
    }

    //var receipt = await web3.eth.getTransactionReceipt(result2.transactionHash);
    //console.log(receipt.status);

    $("#creq_txnhash").val(result2.transactionHash);
    //$("#creq_txnhash").val('test result');
    $("#creq_status").val(result2.status); // true/false
    $("form#purchaseform").submit();
    // $.toast({heading: 'Success',text: "View On  <a target='_blank' href='https://testnet.bscscan.com/tx/"+result+"'> BlockChain </a>" ,icon: 'success',hideAfter: 15000});
  } else if (inputCoin == 1) {
    const result = await bridge_contract.methods
      .swapTokens(0, 1)
      .send({ from: userAddr, value: bnbAmount });
    if (!result) {
      $.toast({
        heading: "Error",
        text: "Transaction reject by user",
        icon: "error",
      });
      return;
    }
    //var receipt = await web3.eth.getTransactionReceipt(result.transactionHash);
    $("#creq_txnhash").val(result.transactionHash);
    $("#creq_status").val(result.status);
    $("form#purchaseform").submit();
    // $.toast({heading: 'Success',text: "View On  <a target='_blank' href='https://testnet.bscscan.com/tx/"+result+"'> BlockChain </a>" ,icon: 'success',hideAfter: 15000});
  } else if (inputCoin == 2) {
    const result = await Token_contract.methods
      .transfer(receive_add, amount)
      .send({ from: userAddr });

    if (!result) {
      $.toast({
        heading: "Error",
        text: "Transaction reject by user",
        icon: "error",
      });
      return;
    }
    // console.log(result);
    //var receipt = await web3.eth.getTransactionReceipt(result.transactionHash);
    // console.log(receipt);
    //result = web3.eth.getTransactionReceipt;

    $("#creq_txnhash").val(result.transactionHash);
    $("#creq_status").val(result.status);
    $("form#purchaseform").submit();
    // $.toast({heading: 'Success',text: "View On  <a target='_blank' href='https://testnet.bscscan.com/tx/"+result+"'> BlockChain </a>" ,icon: 'success',hideAfter: 15000});
  }
};

const amount_withdraw = async () => {

  if (!localStorage.getItem("connectedwallet")) {
    alert("Kindly connect your wallet");
    return;
  }


  var inputAmt = $("#withdaw_amount").val();
  var cuRate = $("#form_current_price").val();

  if (inputAmt <= 0) {
    $.toast({ heading: "Error", text: "Invalid Amount", icon: "error" });
    return false;
  }

  //var weiAmt      = 1000000000000000000*inputAmt;
  //var hexaDecimal =  "0x"+weiAmt.toString(16);
  var Token_contract = new web3.eth.Contract(token_abi, token_address);
  var bridge_contract = new web3.eth.Contract(buy_abi, buy_addr);

  var inputAmtToken = parseInt(inputAmt / cuRate);
  //const amount = web3.utils.toWei(inputAmtToken.toString(), 'ether');
  const amount = web3.utils.toWei(
    inputAmtToken.toFixed(17).toString(),
    "ether"
  );
  //const aprove_amount = web3.utils.toWei((inputAmtToken*1000).toFixed(17).toString(), 'ether');

  console.log(inputAmtToken);
  /*
        await Token_contract.methods.approve(buy_addr,aprove_amount).send({from:userAddr},function(err, result){ 		
            if(err!==null){
                $.toast({heading: 'Error',text: "Transaction reject by user" ,icon: 'error'}); 
                return;
            }
             
        })
        */

  const result = await bridge_contract.methods
    .withdraw(amount)
    .send({ from: userAddr });
  if (!result) {
    $.toast({
      heading: "Error",
      text: "Transaction reject by user",
      icon: "error",
    });
    return;
  }
  var receipt = await web3.eth.getTransactionReceipt(result.transactionHash);
  $("#creq_txnhash").val(result.transactionHash);
  $("#creq_status").val(receipt.status);
  $("form#purchaseform").submit();
  // $.toast({heading: 'Success',text: "View On  <a target='_blank' href='https://testnet.bscscan.com/tx/"+result+"'> BlockChain </a>" ,icon: 'success',hideAfter: 15000});
};

// Event Listeners
window.ethereum.on("accountsChanged", (accounts) => {
  window.location.reload();
});

window.ethereum.on("chainChanged", (chainId) => {
  window.location.reload();
});

window.addEventListener("DOMContentLoaded", startup);
