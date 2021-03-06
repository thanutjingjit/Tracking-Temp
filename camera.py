import cv2
import sys
import serial
import time
import numpy as np
import face_recognition as fr
import requests
import json
import os.path
from os import path


def GetImages():
    result = requests.get(endPoint + '/services/get_images.php')
    return result.text.split(',')


# endPoint = 'http://localhost/tracking-temp/'
endPoint = 'https://tracking-temp.thesis-su2020ict.com'

cascPath = "haarcascade_frontalface_default.xml"
faceCascade = cv2.CascadeClassifier(cascPath)

video_capture = cv2.VideoCapture(0)

font = cv2.FONT_HERSHEY_SIMPLEX

org = (50, 50)
fontScale = 1
color = (255, 0, 0)
thickness = 2

imgs = GetImages()

# print(imgs)

known_face_names = []
known_face_encondings = []
files = []

for img_name in imgs:
    img_data = requests.get(endPoint + '/uploads/' + img_name).content
    with open('./uploads/'+img_name, 'wb') as handler:
        # if(path.exists('./uploads/'+img_name) == False):
        time.sleep(0.1)
        handler.write(img_data)

print('Get img')
for img_name in imgs:
    if(img_name == ''):
        continue
    img_name = img_name.strip()
    print(img_name)
    if(path.exists('./uploads/'+img_name)):
        image_file = fr.load_image_file('./uploads/' + img_name)
        time.sleep(0.05)
        face_encoding = fr.face_encodings(image_file)
        if(len(face_encoding) != 0):  # checkpeople
            known_face_encondings.append(face_encoding[0])  # ข้อมูลface
            known_face_names.append(img_name)  # ข้อมูล img

# known_face_encondings.resize((2, 128))


def SendTemp(temp, frame, ):

    print("send temp")
    rgb_frame = frame[:, :, ::-1]

    face_locations = fr.face_locations(rgb_frame)
    face_encodings = fr.face_encodings(
        rgb_frame, face_locations)  # รับข้อมูลรูปจาก webcam

    user_id = "0"
    for (top, right, bottom, left), face_encoding in zip(face_locations, face_encodings):  # loop หาหน้าจาก webcam
        matches = fr.compare_faces(
            known_face_encondings, face_encoding)  # หารูปที่แมชกับในระบบ

        # เช็คความแตกต่างของรูปในระบบ กับรูปที่เพิ่งแสกนหน้า
        face_distances = fr.face_distance(known_face_encondings, face_encoding)
        # หน้าแมชที่ดีที่สุด เป็น index
        best_match_index = np.argmin(face_distances)
        if matches[best_match_index]:
            user_id = known_face_names[best_match_index]  # รูปที่แมช

    path = './captures/'
    name_img = ''
    if(user_id != "0"):
        user_id = user_id.split('.')[0].split('-')[1]

    name_img = path + str(time.time()) + '-' + user_id + \
        '.jpg'
    # save  scan  folder captures
    cv2.imwrite(name_img, frame, [cv2.IMWRITE_JPEG_QUALITY, 50])

    # headers = {'content-type': 'application/json'}

    files = {'file': open(name_img, 'rb')}
    data = {
        'temp': temp,
        'img': name_img,
        'user_id': user_id
    }  # จัดข้อมูล json
    result = requests.post(
        endPoint + '/services/py-scan-temp.php', files=files, data=data)
    print(result.text)
    return


# port arduino
arduino = serial.Serial(port='/dev/cu.usbmodem141401', baudrate=9600)
time.sleep(1)
print("Connected to arduino...")

# main
while True:
    ret, frame = video_capture.read()
    temp = str(arduino.readline())

    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    faces = faceCascade.detectMultiScale(
        gray,
        scaleFactor=1.1,
        minNeighbors=5,
        minSize=(30, 30)
        # flags=cv2.CV_HAAR_SCALE_IMAGE
    )  # ตรวจสอบหน้า

    # Draw a rectangle around the faces
    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 10)

    k = cv2.waitKey(1)  # รับ keyboard
    if "detect" in temp:  # ถ้า arduino ส่ง temp ที่มีคำว่า detect มาจะลงข้อมูล
        SendTemp(temp, frame)
    elif k % 256 == 27:
        # ESC pressed
        print("Escape hit, closing...")
        break

    temp = temp.replace("b'", '')
    temp = temp[0:5]
    frame = cv2.putText(frame, temp, org, font, fontScale,
                        color, thickness, cv2.LINE_AA)

    if not ret:
        print("failed to grab frame")
        break
    cv2.imshow("test", frame)


# When everything is done, release the capture
video_capture.release()
cv2.destroyAllWindows()
