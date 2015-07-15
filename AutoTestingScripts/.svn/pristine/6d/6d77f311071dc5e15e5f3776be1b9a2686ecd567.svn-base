'''
Created on 2010-10-13

@author: christie.duan
'''
import time


def my_wait_element(self, element): 
    for i in range(0, 80):
        if self.selenium.is_element_present(element) == True :
            return True
        else :
            time.sleep(1)
    return False

def my_wait_title(self,text):
##     for i in range(80):
##       try:
##           if self.selenium.get_title().find(text)<0: break
##       except: pass
##       time.sleep(1)
##     else: self.fail("time out")
    for i in range(0,80):
        if self.selenium.get_title().find(text)<0:
            time.sleep(1)
    return False

def my_wait_text_present(self,text):
     for i in range(80):
       try:
           if self.selenium.is_text_present(text): break
       except: pass
       time.sleep(1)
     else: self.fail("time out")
