'''
Created on 2010-10-14

@author: christie.duan
'''
import FunctionCommon

def AddCart(self,qty):
    FunctionCommon.my_wait_element(self,"qty_")
    self.selenium.select("qty_", "label="+qty)
    FunctionCommon.my_wait_element(self,"//div[@id='ProductDetails']/div/form/div/dl[2]/dd/div/input")
    self.selenium.click("//div[@id='ProductDetails']/div/form/div/dl[2]/dd/div/input")
    
def CheckOut(self):
    FunctionCommon.my_wait_element(self,"//div[@id='CartContent']/div/div[1]/div[2]/div[1]/a/img")
    self.selenium.click("//div[@id='CartContent']/div/div[1]/div[2]/div[1]/a/img")
    # step1 Account Detail: Checkout as a guest
    FunctionCommon.my_wait_element(self,"checkout_type_guest")
    self.selenium.click("checkout_type_guest")
    FunctionCommon.my_wait_element(self,"CreateAccountButton")
    self.selenium.click("CreateAccountButton")