'''
Created on 2011-02-25

@author: iris chen
'''
import PublicFunctions
import time

def AddCart(self):
    PublicFunctions.my_wait_element(self,"//input[@type='image' and @onclick='return chksubmit()']")
    self.selenium.click("//input[@type='image' and @onclick='return chksubmit()']")
    
def CheckOut(self):    
    PublicFunctions.my_wait_title(self,"Click here to proceed to checkout")
    time.sleep(5)
    sel = self.selenium
    sel.click("//img[contains(@src, 'images/blue/CheckoutButton.gif') and @alt='']")
    time.sleep(5)
    
    for i in range(0, 8):
        if sel.get_title().find("Express Checkout")<0 or sel.is_element_present("//input[@value='Continue shopping']"):break
        else :
            time.sleep(1)
            
    if sel.is_element_present("//input[@value='Continue shopping']"):
        sel.click("//input[@value='Checkout']")

    PublicFunctions.my_wait_text_present(self,"Express Checkout")
    

def UpdateQty(self,qty):
    PublicFunctions.my_wait_element(self,"qty_0")
    self.selenium.type("qty_0",qty)
    self.selenium.click("//input[@value='Recalculate']")
    self.selenium.wait_for_page_to_load("30000")
    
    
