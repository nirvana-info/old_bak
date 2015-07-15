'''
Created on 2011-02-25

@author: iris chen
'''
import PublicFunctions


def addToCard(self, number):
    PublicFunctions.my_wait_element(self,"//div[@id='ProductDetails']/div/form/div/dl[2]/dd/div/input")
    self.selenium.select("qty_", "label="+number)
    self.selenium.click("//div[@id='ProductDetails']/div/form/div/dl[2]/dd/div/input")


def Step1_ProceedCheckOut(self,NewBill):
    if NewBill == False:
        self.selenium.click("//input[@value='Bill & Ship to this Address']")
    else:
        self.selenium.click("BillingAddressTypeNew")
        self.selenium.type("FormField_4","iris")
        self.selenium.type("FormField_5","chen")
        self.selenium.type("FormField_7","123456")
        self.selenium.type("FormField_8","new york")
        self.selenium.type("FormField_10","new york")
        self.selenium.select("FormField_12","lable=Arizona")
        self.selenium.type("FormField_13","15535")
        self.selenium.click("ShippingAddressTypeNew")
           
def Step2_ChooseBillingShipAddress(self):
    PublicFunctions.my_wait_element(self,"//input[@value='Bill & Ship to this Address']")
    self.selenium.click("//input[@value='Bill & Ship to this Address']")
    
def Step3_ShippingMethod(self):
    PublicFunctions.my_wait_element(self,"//input[@value='Free Customer Pickup']")
    self.selenium.click("//input[@value='Free Customer Pickup']")
   
def Step4_OrderConfirm(self):
    PublicFunctions.my_wait_element(self,"bottom_payment_button")
    self.selenium.click("bottom_payment_button")
    
def Step5_PaymentDetails(self):
    PublicFunctions.my_wait_element(self,"//div[@id='CheckoutStepPaymentDetails']/div[1]/form[1]/div[1]/dl[1]/dd[11]/p/input")
    self.selenium.type("//div[@id='CheckoutStepPaymentDetails']/div[1]/form[1]/div[1]/dl[1]/dd[2]/div[1]/input","4111111111111111")
    self.selenium.click("//div[@id='CheckoutStepPaymentDetails']/div[1]/form[1]/div[1]/dl[1]/dd[11]/p/input")
    
    
