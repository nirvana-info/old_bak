'''
Created on 2010-11-25

@author: Administrator
'''

import PublicFunctions


def addToCard(self, number):
    PublicFunctions.my_wait_element(self,"//div[@id='ProductDetails']/div/form/div/dl[2]/dd/div/input")
    self.selenium.select("qty_", "label="+number)
    self.selenium.click("//div[@id='ProductDetails']/div/form/div/dl[2]/dd/div/input")
    
def Step1_ProceedCheckOut(self):
    PublicFunctions.my_wait_element(self,"//div[@id='CartContent']/div/div[1]/div[2]/div[1]/a/img")
    self.selenium.click("//div[@id='CartContent']/div/div[1]/div[2]/div[1]/a/img")
    
def Step2_ChooseBillingShipAddress(self):
    PublicFunctions.my_wait_element(self,"//input[@value='Bill & Ship to this Address']")
    self.selenium.click("//input[@value='Bill & Ship to this Address']")
    
def Step3_ShippingMethod(self):
    PublicFunctions.my_wait_element(self,"//div[@id='CheckoutStepShippingProvider']/div[1]/form[1]/ul/li/label/input")
    self.selenium.click("//div[@id='CheckoutStepShippingProvider']/div[1]/form[1]/ul/li/label/input")
    self.selenium.click("//div[@id='CheckoutStepShippingProvider']/div[1]/form[1]/div[2]/input")
    #self.selenium.click("//input[@value='Continue']")
    
def Step4_OrderConfirm(self):
    PublicFunctions.my_wait_element(self,"bottom_payment_button")
    self.selenium.click("bottom_payment_button")
    
def Step5_PaymentDetails(self):
    PublicFunctions.my_wait_element(self,"//div[@id='CheckoutStepPaymentDetails']/div[1]/form[1]/div[1]/dl[1]/dd[11]/p/input")
    self.selenium.type("//div[@id='CheckoutStepPaymentDetails']/div[1]/form[1]/div[1]/dl[1]/dd[2]/div[1]/input","4111111111111111")
    self.selenium.click("//div[@id='CheckoutStepPaymentDetails']/div[1]/form[1]/div[1]/dl[1]/dd[11]/p/input")
    
    